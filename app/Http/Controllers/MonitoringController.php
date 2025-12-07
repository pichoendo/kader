<?php

namespace App\Http\Controllers;

use App\Http\Resources\DPDResourceCollection;
use App\Models\DPDCount;
use App\Models\Jenjang;
use Illuminate\Http\Request;
use View;

class MonitoringController extends Controller
{
    private $title = "Monitoring & Evaluasi";

    public function __construct()
    {
        View::share('title', $this->title);
    }



    public function getData(Request $request)
    {
        $d = $request->all();

        $data = DPDCount::whereHas('anggota', function ($q) {
            $q->where('is_kader', 1);
        });

        if (array_key_exists('dpd_id', $d)) {
            if (strlen($d['dpd_id']) > 0) {
                $data = $data->where('id',   $d['dpd_id']);
            }
        }

        if (array_key_exists('dpw_id', $d)) {
            if (strlen($d['dpw_id']) > 0) {
                $data = $data->where('province_id',   $d['dpw_id']);
            }
        }
        $data = $data->with(['provinsi'])->orderBy('province_id')->get();
        return new DPDResourceCollection(0, 1, $data);
    }

    public function index()
    {
        return view('monitoring.index', ['jenjang' => Jenjang::where('id', '>', 0)->get()]);
    }
}
