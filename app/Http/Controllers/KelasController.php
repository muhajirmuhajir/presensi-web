<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        $kelas = Kelas::with('courses', 'students')->withCount('courses', 'students')->findOrFail($id);

        return view('pages.kelas.show',compact('kelas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function edit(Kelas $kelas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kelas $kelas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kelas $kelas)
    {
        //
    }

    public function addStudent(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);
        $students = User::whereHas('roles', function ($q){
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

        User::findOrFail($request->student_id)->update(['kelas_id' => $kelas->id]);

        return redirect()->back();
    }
}
