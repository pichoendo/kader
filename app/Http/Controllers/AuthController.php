<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Log;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use View;

class AuthController extends Controller
{
    private $title = "SIREKAT";

    public function __construct()
    {
        View::share('title', $this->title);
    }

    public function index()
    {
        return view('auth/index');
    }

    public function checkOtp()
    {
        return now();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function request(Request $req)
    {
        $time = [0, 60, 300, 500, 5000, 6000];
        $r = $req->all();
        $r['device_id'] = $r['no_kontak'];
        $anggota = Anggota::where('no_kontak', $r['no_kontak'])->with('jabatan')->first();

        if ($anggota != null) {

            if ($anggota->jabatan->sikader_group != null) {
                if (in_array($anggota->jabatan->sikader_group, [1, 2])) {
                    if ($anggota->jabatan->sikader_group == 1) {
                        if ($anggota->departemen_id != 2) {
                            return response()->json([
                                'code' => 400,
                                'wait' => -1,
                                'message' => 'Anda Tidak Di Izinkan Mengakses Sistem!',
                            ]);
                        }
                    }
                    $log = Log::where('device_id', $r['no_kontak'])->first();
                    if (!$log) {
                        $log = Log::create($r);
                    }

                    $diff = $log->updated_at->diffInSeconds(now());

                    if ($log->updated_at->addSecond($time[$log->request]) <= now()) {

                        $kode = rand(pow(10, 5 - 1), pow(10, 5) - 1);
                        $kode = 12345;
                        $anggota->password = Hash::make($kode);
                        $anggota->generate_password_at = now();
                        $anggota->save();
                        if ($log->request < 5) {
                            $log->request++;
                            $log->save();
                        }
                        //Libs::sendKode($anggota->no_kontak,$kode);
                        $diff = $log->updated_at->addSecond($time[$log->request])->diffInSeconds(now());
                        return response()->json([
                            'code' => 200,
                            'wait' => $diff,
                            'message' => 'Silahkan Check Ponsel Anda !',
                        ]);
                    } else {
                        return response()->json([
                            'code' => 400,
                            'wait' => $diff,
                            'message' => 'Silahkan Coba dalam ' . $diff . ' detik ! ',
                        ]);
                    }
                }
                return response()->json([
                    'code' => 400,
                    'wait' => -1,
                    'message' => 'Anda Tidak Di Izinkan Mengakses Sistem !',
                ]);
            }

            return response()->json([
                'code' => 400,
                'wait' => -1,
                'message' => 'Anda Tidak Di Izinkan Mengakses Sistem !',
            ]);
        }
        return response()->json([
            'code' => 400,
            'wait' => -1,
            'message' => 'Nomor Tidak Terdaftar !',
        ]);
    }

    public function login(Request $req)
    {

        $r = $req->all();

        $credentials = request(['no_kontak', 'password']);

        if (!Auth::attempt($credentials)) {
            return redirect()->back()->withErrors([
                'message' => 'Kode OTP Salah !',
            ]);
        }

        if (Carbon::parse(Auth::user()->generate_password_at)->diffInMinutes(now()) > 5) {
            Auth::logout();
            return redirect()->back()->withErrors([
                'message' => 'OTP Tidak Berlaku ! Silahkan Request Ulang',
            ]);
        }

        $log = Log::where('device_id', $r['no_kontak'])->first();
        $log->request = 0;
        $log->save();

        return redirect()->route('monitoring');
    }
}
