<?php

namespace App\Http\Controllers;

use App\Exports\RekapPresensiExport;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Course;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->hasRole(config('enums.roles.bk'))) {
            $data = Course::join('kelas as k', 'k.id', 'courses.kelas_id')
                ->join('users as u', 'u.id', 'courses.teacher_id')
                ->select(
                    'courses.id as id',
                    'k.name as kelas_name',
                    'courses.name as course_name',
                    'u.name as teacher_name'
                )->get();
        } else {
            $data = Course::join('kelas as k', 'k.id', 'courses.kelas_id')
                ->where('courses.teacher_id', auth()->user()->id)
                ->select(
                    'courses.id as id',
                    'k.name as kelas_name',
                    'courses.name as course_name'
                )
                ->get();
        }


        return view('pages.course.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Gate::allows('modif-course')){
            abort(403);
        }

        $teachers = User::whereHas('roles', function ($q) {
            $q->where('name', config('enums.roles.teacher'));
        })->get();

        $kelas = Kelas::all();

        return view('pages.course.create', compact('teachers', 'kelas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Gate::allows('modif-course')){
            abort(403);
        }

        $fields = $request->validate([
            'teacher_id' => 'required|exists:users,id',
            'kelas_id' => 'required|exists:kelas,id',
            'name' => 'required'
        ]);

        Course::create($fields);

        return redirect()->route('course.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        $course->load('kelas.students', 'presensi','teacher');
        return view('pages.course.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        if(!Gate::allows('modif-course')){
            abort(403);
        }

        $teachers = User::whereHas('roles', function ($q) {
            $q->where('name', config('enums.roles.teacher'));
        })->get();

        $kelas = Kelas::all();

        return view('pages.course.edit', compact('course', 'teachers', 'kelas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        if(!Gate::allows('modif-course')){
            abort(403);
        }

        $fields = $request->validate([
            'teacher_id' => 'required|exists:users,id',
            'kelas_id' => 'required|exists:kelas,id',
            'name' => 'required'
        ]);

        $course->update($fields);

        return redirect()->route('course.show', $course);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        if(!Gate::allows('modif-course')){
            abort(403);
        }

        $course->presensi()->delete();
        $course->delete();

        return redirect()->route('course.index');
    }

    public function rekapPresensi(Request $request, $id)
    {

        $course = Course::findOrFail($id);
        if(!Gate::allows('modif-course')){
            abort(403);
        }

        $kelas_name = $course->fullName();
        $filename = 'Rekap '.Str::upper(Str::slug($kelas_name));
        return (new RekapPresensiExport)->withCourseId($id)->download($filename . '.xlsx');
    }
}
