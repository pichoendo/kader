<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\LogDetailProgram;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function konfirmasi(Request $request)
    {
        $data = $request->all();
        $status = ['', '', 'Di Tunda', 'Terlaksana', 'Di Batalkan'];
        $i = 0;
        foreach ($data['statusPelaksanaan'] as $p) {
            $kegiatan = Kegiatan::find($data['kegiatan_id'][$i]);
            if ($p != 2) {
                $kegiatan->update(['status' => $p]);
            } else {
                $kegiatan->update(['status' => $p, 'tanggal' => $data['tanggal'][$i], 'tempat' => $data['tempat'][$i]]);
            }
            $i++;
            LogDetailProgram::create([
                "detail_program_id" => $kegiatan->detail_program_id,
                "keterangan" => "Konfirmasi Status Pelaksanaan Kegiatan " . $status[$p],
                "anggota_id" => auth()->user()->id,
            ]);
        }

        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kegiatan  $kegiatan
     * @return \Illuminate\Http\Response
     */
    public function show(Kegiatan $kegiatan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kegiatan  $kegiatan
     * @return \Illuminate\Http\Response
     */
    public function edit(Kegiatan $kegiatan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kegiatan  $kegiatan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kegiatan $kegiatan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kegiatan  $kegiatan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kegiatan $kegiatan)
    {
        //
    }
}
