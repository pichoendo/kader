<?php

namespace App\Http\Controllers;

use App\Http\Resources\LogKaderisasiResourceCollection;
use App\Http\Resources\KaderResourceCollection;
use App\Models\Anggota;
use App\Models\LogKaderisasi;
use App\Models\StatusKaderisasiAnggota;
use Illuminate\Http\Request;
use View;

class KaderController extends Controller
{
    private $title = "Kader";

    public function __construct()
    {
        View::share('title', $this->title);
    }


    public function getDataHistori(Request $request, Anggota $anggota)
    {
        $d = $request->all();
        $data = LogKaderisasi::where('anggota_id', $anggota->id);
        $data = $data->with(['jenjang_kaderisasi'])->paginate(15);
        return new LogKaderisasiResourceCollection(0, 1, $data);
    }

    public function getData(Request $request)
    {
        $d = $request->all();
        $data = Anggota::where('is_kader', 1)->where('status', '>', 0)->whereHas('dpd', function ($q) use ($d) {
            if (array_key_exists('dpw_id', $d)) {
                if ($d['dpw_id'] > -1) {
                    $q =  $q->where('province_id', $d['dpw_id']);
                }
            }
            if (array_key_exists('dpd_id', $d)) {
                if ($d['dpd_id'] > -1) {
                    $q =  $q->where('id', $d['dpd_id']);
                }
            }
        });

        if (array_key_exists('nama', $d)) {
            if (strlen($d['nama']) > 0) {
                $data = $data->where('nama_lengkap', 'like', '%' . $d['nama'] . '%');
            }
        }
        $data = $data->with(['dpd', 'status_kader'])->paginate(15);
        return new KaderResourceCollection(0, 1, $data);
    }

    public function index()
    {
        return view('kader/index');
    }

    public function view(Anggota $anggota)
    {
        return view('kader/view', ['anggota' => $anggota]);
    }

    public function updateJenjang(Request $req)
    {
        $data = Anggota::where('id', $req->input('id'))->first();

        $data->update([
            'jenjang_kaderisasi_id' => $req->input('jenjang_kaderisasi_id')
        ]);
        LogKaderisasi::create([
            'anggota_id' => $data->id,
            'jenjang_kaderisasi_id' => $req->input('jenjang_kaderisasi_id')
        ]);
        return redirect()->route('viewKader', $req->input('id'));
    }
    public function addKader(Request $req)
    {

        $data = Anggota::where('id', $req->input('anggota_id'))->first();
        $data->update([
            'is_kader' => 1,
            'jenjang_kaderisasi_id' => $req->input('jenjang_kaderisasi_id')
        ]);
        LogKaderisasi::create([
            'anggota_id' => $data->id,
            'jenjang_kaderisasi_id' => $req->input('jenjang_kaderisasi_id')
        ]);
        return redirect()->back();
    }
    public function update()
    {
    }

    public function edit()
    {
    }
}
