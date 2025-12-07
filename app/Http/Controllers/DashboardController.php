<?php

namespace App\Http\Controllers;

use App\Models\DPD;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use View;

class DashboardController extends Controller
{
    private $title = "Dashboard";

    public function __construct()
    {
        View::share('title', $this->title);
    }
    public function dataComboDpd(Request $request)
    {
        $r = $request->all();
        $data = DPD::where('nama', 'like', '%' . $request->input('q') . '%');
        if (array_key_exists('dpw_id', $r)) {
            if ($r['dpw_id'] != 'null')
                $data = $data->where('province_id', $r['dpw_id']);
        }
        return response()->json($data->take(10)->get());
    }
    public function dataComboDpw(Request $request)
    {
        return response()->json(Provinsi::where('nama', 'like', '%' . $request->input('q') . '%')->take(10)->get());
    }
    public function blank()
    {
        return view('dashboard.blank');
    }

    public function index()
    {
        return view('dashboard.index');
    }
}
