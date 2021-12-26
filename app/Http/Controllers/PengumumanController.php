<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
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
        $data = Pengumuman::with('course')->get();

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

        Pengumuman::create([
            'course_id' => $request->course_id,
            'user_id' => auth()->user()->id,
            'title' => $request->title,
            'body' => $request->body,
            'thumbnail_url' => $thumbnail_url
        ]);

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
}
