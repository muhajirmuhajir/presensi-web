<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PresensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = Presensi::join('courses as c', 'c.id', 'presensis.course_id')
            ->join('kelas as k', 'k.id', 'c.kelas_id')
            ->where('c.teacher_id', auth()->user()->id)
            ->select(
                'presensis.id as id',
                DB::raw("CONCAT(k.name, ' - ', c.name) as kelas_name"),
                'presensis.topic as topic',
                'presensis.open_date as open_date',
                'presensis.close_date as close_date'
            )->get();

        return view('pages.presensi.index', compact('data'));
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
        $fields = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'topic' => 'required',
            'question' => 'nullable',
            'open_date' => 'required',
            'close_date' => 'required',
        ]);

        Presensi::create($fields);

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Presensi  $presensi
     * @return \Illuminate\Http\Response
     */
    public function edit(Presensi $presensi)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Presensi  $presensi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Presensi $presensi)
    {
        //
    }
}
