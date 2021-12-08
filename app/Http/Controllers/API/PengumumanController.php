<?php

namespace App\Http\Controllers\API;

use App\Models\Pengumuman;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class PengumumanController extends Controller
{
    public function index()
    {
        $kelas_id = auth()->user()->kelas_id ?? 0;

        $pengumuman =  Pengumuman::whereIn('course_id', function ($q) use ($kelas_id) {
            return $q->select('id')->from('courses')->where('kelas_id', $kelas_id);
        })
            ->orWhereNull('course_id')
            ->select('id', 'title', 'body as content', 'thumbnail_url as thumbnail')
            ->get();

        $pengumuman = $pengumuman->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'content' => $item->content,
                'thumbnail' => url(Storage::url($item->thumbnail))
            ];
        });

        return ApiResponse::success($pengumuman);
    }

    public function show(Request $request, $id)
    {

        $pengumuman =  Pengumuman::with('teacher')->findOrFail($id);
        $pengumuman->thumbnail = url(Storage::url($pengumuman->thumbnail_url));
        $pengumuman->content = $pengumuman->body;
        $pengumuman->created_date = Carbon::parse($pengumuman->created_at)->isoFormat('d/m/Y HH:mm');

        return ApiResponse::success($pengumuman);
    }
}
