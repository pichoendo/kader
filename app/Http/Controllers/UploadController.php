<?php

namespace App\Http\Controllers;

use App\Models\GambarLaporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class UploadController extends Controller
{
    public function uploadDokumentasi(Request $request)
    {
        $tujuan_upload = 'data_file';
        $file = $request->file('file');
        $name = now()->timestamp . "_" . uniqid(12) . "." . $request->file('file')->getClientOriginalExtension();
        $file->move($tujuan_upload, $name);
        return response()->json(["result" => $name]);

    }

    public function delete(Request $request)
    {
        if (File::exists($request->input('file'))) {
            File::delete($request->input('file'));
        }

    }

    public function deleteById(Request $request)
    {
        $gambar = GambarLaporan::find($request->input('id'));

        $fl = 'data_file/' . $gambar->image_url;
        if (File::exists($fl)) {
            File::delete($fl);
        }
        $gambar->delete();
        return response()->json(200);

    }
}
