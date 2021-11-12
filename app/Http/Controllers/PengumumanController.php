<?php

namespace App\Http\Controllers;

use App\Http\Requests\PengumumanStoreRequest;
use App\Models\Course;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengumumanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Pengumuman::all();

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
        ]);

        $thumbnail_url = $request->thumbnail->store('thumbnail','public');

        Pengumuman::create([
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pengumuman  $pengumuman
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pengumuman $pengumuman)
    {
        //
    }
}
