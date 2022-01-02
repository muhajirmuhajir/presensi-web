<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Course;
use App\Models\Presensi;
use Illuminate\Http\Request;
use App\Models\PresensiRecord;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Gate::allows('modif-kelas')){
            abort(403);
        }

        $data = Kelas::withCount('courses')->paginate();

        return view('pages.kelas.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Gate::allows('modif-kelas')){
            abort(403);
        }

        return view('pages.kelas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Gate::allows('modif-kelas')){
            abort(403);
        }

        $request->validate(['name' => 'required']);

        Kelas::create(['name' => $request->name]);

        return redirect()->route('kelas.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!Gate::allows('modif-kelas')){
            abort(403);
        }

        $kelas = Kelas::with('courses.teacher', 'students')->withCount('courses', 'students')->findOrFail($id);

        return view('pages.kelas.show', compact('kelas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Gate::allows('modif-kelas')){
            abort(403);
        }

        $kelas = Kelas::findOrFail($id);
        return view('pages.kelas.edit', compact('kelas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(!Gate::allows('modif-kelas')){
            abort(403);
        }

        $kelas = Kelas::findOrFail($id);

        $request->validate([
            'name' => 'required|string'
        ]);

        $kelas->update(['name' => $request->name]);

        return redirect()->route('kelas.show', $kelas);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!Gate::allows('modif-kelas')){
            abort(403);
        }

        $kelas = Kelas::findOrFail($id);

        User::where('kelas_id', $id)->update(['kelas_id' => null]);

        $course_ids = Course::where('kelas_id', $id)->pluck('id');
        $presensi_ids = Presensi::whereIn('course_id', $course_ids)->pluck('id');

        PresensiRecord::whereIn('presensi_id', $presensi_ids)->delete();

        Course::whereIn('id', $course_ids)->delete();

        Presensi::whereIn('id', $presensi_ids)->delete();

        $kelas->delete();

        return redirect()->route('kelas.index');
    }

    public function addStudent(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);
        $students = User::whereHas('roles', function ($q) {
            $q->where('name', config('enums.roles.student'));
        })->whereNull('kelas_id')->get();

        return view('pages.kelas.add_student', compact('students', 'kelas'));
    }

    public function storeStudent(Request $request, $id)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id'
        ]);

        $kelas = Kelas::findOrFail($id);

        User::findOrFail($request->student_id)->update(['kelas_id' => $kelas->id, 'opening_status' => User::STATUS_ACTIVATED]);

        return redirect()->back();
    }

    public function destroyStudent($id, $student_id)
    {
        $student = User::findOrFail($student_id);
        $student->update(['kelas_id' => null, 'opening_status' => User::STATUS_SUSPENDED]);

        return redirect()->back();
    }
}
