<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PengumumanController extends Controller
{
    public function index()
    {
        $kelas_id = auth()->user()->kelas_id ?? 0;

        $pengumuman =  Pengumuman::whereIn('course_id', function ($q) use($kelas_id){
            return $q->select('id')->from('courses')->where('kelas_id', $kelas_id);
        })->select('id', 'title', 'body as content', 'thumbnail_url as thumbnail')
        ->get();

        return ApiResponse::success($pengumuman);
    }

    public function show(Request $request, $id)
    {

        $pengumuman =  Pengumuman::with('teacher')->findOrFail($id);

        return ApiResponse::success($pengumuman);

    }
}
