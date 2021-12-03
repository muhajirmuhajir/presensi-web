<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use App\Models\PresensiRecord;
use Illuminate\Http\Request;

class PresensiRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Presensi $presensi)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Presensi $presensi)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Presensi $presensi)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PresensiRecord  $presensiRecord
     * @return \Illuminate\Http\Response
     */
    public function show(Presensi $presensi, $id)
    {
        $record = PresensiRecord::with('student')->findOrFail($id);
        $presensi_status = PresensiRecord::STATUS_ARRAY;
        return view('pages.presensi.record.show', compact('presensi', 'record', 'presensi_status'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PresensiRecord  $presensiRecord
     * @return \Illuminate\Http\Response
     */
    public function edit(Presensi $presensi, PresensiRecord $presensiRecord)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PresensiRecord  $presensiRecord
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Presensi $presensi, $id)
    {
        $fields = $request->validate([
            'status' => 'required|string'
        ]);

        $record = PresensiRecord::findOrFail($id);

        $record->update($fields);

        return redirect()->route('presensi.show', $presensi);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PresensiRecord  $presensiRecord
     * @return \Illuminate\Http\Response
     */
    public function destroy(Presensi $presensi, $id)
    {
        $record = PresensiRecord::findOrFail($id);
        $record->delete();

        return redirect()->route('presensi.show', $presensi);
    }
}
