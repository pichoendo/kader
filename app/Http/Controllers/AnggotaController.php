<?php

namespace App\Http\Controllers;

use App\Http\Resources\AnggotaResourceCollection;
use App\Models\Anggota;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{

    public function getDataAnggotaDepartemen(Request $requset, $id)
    {
        $d = $requset->all();
        $data = Anggota::where('status', '>', 0)->where('departemen_id', $id);

        if (array_key_exists('q', $d)) {
            $data = $data->where('nama_lengkap', 'like', '%' . $d['q'] . '%');
        }

        $data = $data->select(['id', 'nama_lengkap'])->paginate(15);

        return new AnggotaResourceCollection(0, 1, $data);
    }

    public function getData(Request $requset)
    {
        $d = $requset->all();
        $data = Anggota::where('status', '>', 0);

        if (array_key_exists('is_kader', $d)) {
            $data = $data->where('is_kader', $d['is_kader']);
        }

        if (array_key_exists('q', $d)) {
            $data = $data->where('nama_lengkap', 'like', '%' . $d['q'] . '%');
        }
        $data = $data->select(['id', 'nama_lengkap'])->paginate(15)->makeHidden(['notifikasi']);

        return new AnggotaResourceCollection(0, 1, $data);
    }

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
     * @param  \App\Models\Anggota  $anggota
     * @return \Illuminate\Http\Response
     */
    public function show(Anggota $anggota)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Anggota  $anggota
     * @return \Illuminate\Http\Response
     */
    public function edit(Anggota $anggota)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Anggota  $anggota
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Anggota $anggota)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Anggota  $anggota
     * @return \Illuminate\Http\Response
     */
    public function destroy(Anggota $anggota)
    {
        //
    }
}
