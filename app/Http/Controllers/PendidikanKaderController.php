<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Http\Resources\KaderResourceCollection;
use App\Models\Anggota;
use App\Models\PendidikanKader;
use App\Models\PesertaPendidikan;
use Illuminate\Http\Request;
use View;
use Maatwebsite\Excel\Facades\Excel;

class PendidikanKaderController extends Controller
{

    private $title = "Pendidikan Kader";

    public function __construct()
    {
        View::share('title', $this->title);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('pendidikanKader/index');
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
    public function importPeserta(Request $req, PendidikanKader $pendidikanKader)
    {
        $req->validate([
            'file' => 'required|mimes:csv,xlsx,xls'
        ], [
            'file.mimes' => 'File harus berformat CSV, XLSX, atau XLS.',
        ]);

        try {
            $rows = Excel::toArray([], $req->file('file'))[0];
        } catch (\Exception $e) {
            Log::error("Gagal membaca file Excel: " . $e->getMessage());
            return back()->withErrors("Gagal membaca file Excel: " . $e->getMessage());
        }

        if (empty($rows)) {
            return back()->withErrors("File Excel kosong atau tidak dapat dibaca.");
        }

        array_shift($rows); // Hapus header

        foreach ($rows as $index => $row) {

            try {
                $idAnggota = trim($row[0] ?? '');
                $nama      = trim($row[1] ?? '');
                $judul   = trim($row[2] ?? '');
                $status   = strtolower(trim($row[3] ?? ''));

                $anggota = Anggota::where('kode', 'like', "%{$idAnggota}%")->first();

                if (empty($anggota)) {
                    Log::error("ID ANGGOTA TIDAK AD ${idAnggota}");
                    throw new \Exception("ID Anggota kosong pada baris ke " . ($index + 2));
                }

                $statusMap = [
                    'aktif' => 1,
                    'lulus' => 2,
                    'tidak lulus' => 3,
                ];
                $status = $statusMap[$status];
                $pesertaPendidikan = PesertaPendidikan::where('id_anggota', $anggota->id)->where("id_pendidikan_kader", $pendidikanKader->id)->first();

                if (!$pesertaPendidikan) {
                    $pesertaPendidikan = PesertaPendidikan::create([
                        "id_anggota" => $anggota->id,
                        "id_pendidikan_kader" => $pendidikanKader->id,
                        "status" => $status,
                        "judul_task" => $judul
                    ]);
                } else {

                    $pesertaPendidikan->update([
                        "status" => $status,
                        "judul_task" => $judul
                    ]);
                }
            } catch (\Exception $e) {
                Log::error("File Excel kosong atau tidak dapat dibaca.
                ${e}");
                continue;
            }
        }

        return back()->with('success', 'Import selesai!');
    }
    public function getData(Request $request)
    {
        $d = $request->all();
        $data = PendidikanKader::query();

        if (array_key_exists('tahun', $d)) {
            if (strlen($d['tahun']) > 0) {
                $data = $data->where('tahun', 'like', '%' . $d['tahun'] . '%');
            }
        }

        if (array_key_exists('jenjang_kaderisasi_id', $d)) {
            if (strlen($d['jenjang_kaderisasi_id']) > 0) {
                $data = $data->where('jenjang_kaderisasi_id', $d['jenjang_kaderisasi_id']);
            }
        }
        $data = $data->with('jenjang')->withCount([
            'peserta as peserta_lulus' => function ($q) {
                $q->where('status', 2);
            },
            'peserta',
            'peserta as peserta_tidak_lulus' => function ($q) {
                $q->where('status', 3);
            },
        ])->paginate(15);
        return new KaderResourceCollection(0, 1, $data);
    }

    public function getDataPeserta(Request $request, PendidikanKader $pendidikanKader)
    {
        $d = $request->all();
        $data = PesertaPendidikan::where('id_pendidikan_kader', $pendidikanKader->id);
        $data = $data->with(['anggota'])->paginate(15);
        return new KaderResourceCollection(0, 1, $data);
    }

    public function updatePeserta(Request $req)
    {
        $data = PesertaPendidikan::where('id', $req->input('id'))->first();

        $data->update([
            'status' => $req->input('status'),
            'judul_task' => $req->input('judul_task')
        ]);

        return redirect()->route('viewPendidikanKader', $req->input('id'));
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
     * @param  \App\Models\PendidikanKader  $pendidikanKader
     * @return \Illuminate\Http\Response
     */
    public function show(PendidikanKader $pendidikanKader)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PendidikanKader  $pendidikanKader
     * @return \Illuminate\Http\Response
     */
    public function edit(PendidikanKader $pendidikanKader)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PendidikanKader  $pendidikanKader
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PendidikanKader $pendidikanKader)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PendidikanKader  $pendidikanKader
     * @return \Illuminate\Http\Response
     */
    public function destroy(PendidikanKader $pendidikanKader)
    {
        //
    }


    public function view(PendidikanKader $pendidikanKader)
    {
        return view('pendidikanKader/view', ['pendidikanKader' => $pendidikanKader]);
    }
}
