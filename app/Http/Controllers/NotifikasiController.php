<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotifikasiResourceCollection;
use App\Models\Notifikasi;
use App\Models\NotifikasiReaded;
use Illuminate\Http\Request;
use View;

class NotifikasiController extends Controller
{
    private $title = "Notifikasi";

    public function __construct()
    {
        View::share('title', $this->title);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $data = $req->all();
        if (!array_key_exists('notifikasi', $data)) {
            $data['notifikasi'] = -1;
        }
        return view('notifikasi.index', ['notifikasi' => $data['notifikasi']]);
    }
    public function read(Request $req)
    {
        NotifikasiReaded::create(['notifikasi_id' => $req->input('id'), 'anggota_id' => auth()->user()->id]);
    }
    public function getData(Request $request)
    {
        $data = Notifikasi::where('type', 2)->where(function ($q) {
            if (auth()->user()->jabatan->sirekat_group == 5) {
                $q->where('departemen_id', auth()->user()->departemen_id)->where('sirekat_group', 5);
            } else if (auth()->user()->jabatan->sirekat_group == 1) {
                $q->where('sirekat_group', 1);
            }
        });
        $data = $data->paginate(10);

        return new NotifikasiResourceCollection(0, 1, $data);
    }
}
