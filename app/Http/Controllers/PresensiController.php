<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Course;
use App\Models\Presensi;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PresensiRecord;
use App\Exports\PresensiExport;
use Illuminate\Support\Facades\DB;
use App\Events\PresensiCreatedEvent;
use Illuminate\Support\Facades\Gate;

class PresensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = [];
        if (auth()->user()->hasRole(config('enums.roles.bk'))) {
            $data = Presensi::join('courses as c', 'c.id', 'presensis.course_id')
                ->join('kelas as k', 'k.id', 'c.kelas_id')
                ->select(
                    'presensis.id as id',
                    DB::raw("CONCAT(k.name, ' - ', c.name) as kelas_name"),
                    'presensis.topic as topic',
                    'presensis.open_date as open_date',
                    'presensis.close_date as close_date',
                    'presensis.created_at as created_at',
                    'presensis.updated_at as updated_at',
                )->latest()
                ->paginate();
        } else {
            $data = Presensi::join('courses as c', 'c.id', 'presensis.course_id')
                ->join('kelas as k', 'k.id', 'c.kelas_id')
                ->where('c.teacher_id', auth()->user()->id)
                ->select(
                    'presensis.id as id',
                    DB::raw("CONCAT(k.name, ' - ', c.name) as kelas_name"),
                    'presensis.topic as topic',
                    'presensis.open_date as open_date',
                    'presensis.close_date as close_date',
                    'presensis.created_at as created_at',
                    'presensis.updated_at as updated_at',
                )->latest()
                ->paginate();
        }



        return view('pages.presensi.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Gate::allows('create-presensi')){
            abort(403);
        }

        $courses = Course::join('kelas as k', 'k.id', 'courses.kelas_id')
            ->where('courses.teacher_id', auth()->user()->id)
            ->select(
                'courses.id as id',
                DB::raw("CONCAT(k.name,' - ',courses.name) as name")
            )->get();
        return view('pages.presensi.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Gate::allows('create-presensi')){
            abort(403);
        }

        $fields = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'topic' => 'required',
            'question' => 'nullable',
            'open_date' => 'required|date',
            'close_date' => 'required|date|after:open_date',
        ]);

        $presensi = Presensi::create($fields);

        event(new PresensiCreatedEvent($presensi));

        return redirect()->route('presensi.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Presensi  $presensi
     * @return \Illuminate\Http\Response
     */
    public function show(Presensi $presensi)
    {
        if(!Gate::allows('show-presensi', $presensi)){
            abort(403);
        }

        $presensi->load('records.student', 'course');
        return view('pages.presensi.show', compact('presensi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Presensi  $presensi
     * @return \Illuminate\Http\Response
     */
    public function edit(Presensi $presensi)
    {
        if(!Gate::allows('modif-presensi', $presensi)){
            abort(403);
        }

        $presensi->load('course');

        return view('pages.presensi.edit', compact('presensi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Presensi  $presensi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Presensi $presensi)
    {
        if(!Gate::allows('modif-presensi', $presensi)){
            abort(403);
        }

        $fields = $request->validate([
            'topic' => 'required|string',
            'question' => 'nullable|string',
            'open_date' => 'required|date',
            'close_date' => 'required|date|after:open_date',
        ]);

        $presensi->update($fields);

        return redirect()->route('presensi.show', $presensi);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Presensi  $presensi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Presensi $presensi)
    {
        if(!Gate::allows('modif-presensi', $presensi)){
            abort(403);
        }

        $presensi->records()->delete();
        $presensi->delete();

        return redirect()->route('presensi.index');
    }

    public function rekapPresensi(Request $request, $id)
    {

        $presensi = Presensi::findOrFail($id);
        if(!Gate::allows('rekap-presensi', $presensi)){
            abort(403);
        }
        $kelas_name = $presensi->fullName();
        $filename = Str::upper(Str::slug($kelas_name)) .'_'. Carbon::parse($presensi->open_at)->isoFormat('D-MM-Y');
        return (new PresensiExport)->withId($id)->download($filename . '.xlsx');
    }
}
