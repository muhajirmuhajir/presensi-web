<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;
use App\Events\PengumumanCreatedEvent;
use App\Jobs\SendPengumumanNotification;
use App\Http\Requests\PengumumanStoreRequest;

class PengumumanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        if(auth()->user()->hasRole(config('enums.roles.teacher')) || auth()->user()->hasRole(config('enums.roles.bk'))){
            $data = Pengumuman::with('course')
            ->where('user_id', auth()->user()->id)->get();
        }else{
            $kelas_id = User::find( auth()->user()->id)->kelas_id;
            if($kelas_id){
                $data = Pengumuman::whereIn('course_id', function($query) use($kelas_id) {
                    $query->select('id')->from('courses')
                    ->where('kelas_id', $kelas_id);
                })->get();
            }
        }

        return view('pages.pengumuman.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses = Course::join('kelas as k', 'k.id', 'courses.kelas_id')
        ->where('courses.teacher_id', auth()->user()->id)
        ->select(
            'courses.id as id',
            DB::raw("CONCAT(k.name,' - ',courses.name) as name")
        )->get();

        return view('pages.pengumuman.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\PengumumanStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'body' => 'required|string',
            'thumbnail' => 'required|file|image|max:2048',
            'course_id' => 'nullable|exists:courses,id'
        ]);

        $thumbnail_url = $request->thumbnail->store('thumbnail','public');

        $pengumuman = Pengumuman::create([
            'course_id' => $request->course_id,
            'user_id' => auth()->user()->id,
            'title' => $request->title,
            'body' => $request->body,
            'thumbnail_url' => $thumbnail_url
        ]);

        $pengumuman->load(['teacher', 'course']);
        event(new PengumumanCreatedEvent($pengumuman));

        return redirect()->route('pengumuman.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pengumuman  $pengumuman
     * @return \Illuminate\Http\Response
     */
    public function show(Pengumuman $pengumuman)
    {
        $pengumuman->load('user');
        return view('pages.pengumuman.show', compact('pengumuman'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pengumuman  $pengumuman
     * @return \Illuminate\Http\Response
     */
    public function edit(Pengumuman $pengumuman)
    {
        if(!Gate::allows('modif-pengumuman', $pengumuman)){
            abort(403);
        }

        $pengumuman->load('course');

        return view('pages.pengumuman.edit', compact('pengumuman'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pengumuman  $pengumuman
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pengumuman $pengumuman)
    {
        if(!Gate::allows('modif-pengumuman', $pengumuman)){
            abort(403);
        }

        $fields  = $request->validate([
            'title' => 'required|string',
            'body' => 'required|string',
            'thumbnail' => 'nullable|file|image|max:2048',
        ]);

        if($request->hasFile('thumbnail')){
            $fields['thumbnail_url'] = $request->thumbnail->store('thumbnail','public');
            unset($fields['thumbnail']);
        }

        $pengumuman->update($fields);

        return redirect()->route('pengumuman.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pengumuman  $pengumuman
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pengumuman $pengumuman)
    {
        if(!Gate::allows('modif-pengumuman', $pengumuman)){
            abort(403);
        }

        $pengumuman->delete();

        return redirect()->route('pengumuman.index');
    }

    private function makeNotification($pengumuman)
    {
        $course_id = $pengumuman->course_id;

        if($course_id){
            $course =  Course::find($course_id);
            if(!$course){
                Log::error('course not found');
                return;
            }

            $users = User::where('kelas_id', $course->kelas_id)->get();

            $this->sendEmail($users, $pengumuman);

        }else{
            $users = User::whereHas('roles', function($q){
                $q->where('name', config('enums.roles.student'));
            })->get();

            $this->sendEmail($users, $pengumuman);
        }
    }

    private function sendEmail($users, $pengumuman)
    {
        $jobs = [];
        foreach ($users as $user) {
            $jobs[] = new SendPengumumanNotification($user, $pengumuman);
        }

        Bus::batch($jobs)->dispatch();
    }
}
