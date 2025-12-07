<?php

namespace App\Http\Controllers;

use App\Http\Requests\DetailProgramRequest;
use App\Http\Requests\EditLaporanRequest;
use App\Http\Requests\FeedbackDetailProgramRequest;
use App\Http\Requests\PenilaianProgramRequest;
use App\Http\Resources\DetailProgramResourceCollection;
use App\Models\DetailProgram;
use App\Models\FeedbackDetailProgram;
use App\Models\GambarLaporan;
use App\Models\Kegiatan;
use App\Models\LaporanDetailProgram;
use App\Models\LogDetailProgram;
use App\Models\LogViewDetailProgram;
use App\Models\LogViewLaporanDetailProgram;
use App\Models\Notifikasi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use View;

class DetailProgramController extends Controller
{

    private $title = "Detail Program";

    public function checkRule($detailProgram)
    {
        if (auth()->user()->jabatan->sirekat_group != 1) {
            if (auth()->user()->departemen_id != $detailProgram->program->rkat->departemen_id) {
                return false;
            }
        }
        return true;
    }
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
    public function penilaianProgram(PenilaianProgramRequest $request)
    {
        $data = (($request))->validated();
        $detailProgram = DetailProgram::find($data['detail_program_id']);
        $data['status'] = 5;
        $detailProgram->update($data);
        $this->hitungPoin($detailProgram);
        Notifikasi::create([
            'type' => 2,
            'sirekat_group' => 5,
            'departemen_id' => $detailProgram->program->rkat->departemen_id,
            'isi_plain' => auth()->user()->jabatan->nama . " baru saja memberikan penilaian untuk Laporan Detail Program " . $detailProgram->nama,
            'isi' => auth()->user()->jabatan->nama . " baru saja memberikan penilaian untuk Laporan Detail Program <a href='" . route("viewDetailProgram", $data['detail_program_id']) . "'>Detail Program " . $detailProgram->nama . "</a>",
        ]);
        return redirect()->back();
    }

    public function hitungPoin($detailProgram)
    {
        $poinKegiatan = (20 / $detailProgram->volume);
        $detailProgram->poin_ketepatan_waktu = 20 - ($detailProgram->kegiatan->where('status', 3)->sum('ganti_waktu') * ($poinKegiatan * 0.2)) - ($detailProgram->kegiatan->where('status', 4)->count() * $poinKegiatan);
        $detailProgram->poin_ketepatan_laporan = (Carbon::parse($detailProgram->upload_laporan_at)->diff(Carbon::parse($detailProgram->kegiatanAkhir->first()->tanggal))->days < 30 ? 20 : 10);
        $detailProgram->poin_serapan_anggaran = 30 * ($detailProgram->serapan_anggaran * 100 / $detailProgram->anggaran) / 100;
        $detailProgram->poin = $detailProgram->poin_ketepatan_waktu + $detailProgram->poin_ketepatan_laporan + $detailProgram->poin_serapan_anggaran + $detailProgram->poin_penilaian_pencapaian_outcome;
        $detailProgram->save();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DetailProgramRequest $request)
    {
        $data = (($request))->validated();
        $detailProgram = DetailProgram::where('program_id', $data['program_id'])->where('is_dummy', 1)->first();
        if ($detailProgram) {
            $data['is_dummy'] = 0;
            $detailProgram->update($data);
        } else {
            $detailProgram = DetailProgram::create($data);
        }
        $i = 0;
        foreach ($request->input('tanggal') as $tgl) {
            Kegiatan::create([
                'detail_program_id' => $detailProgram->id,
                'tanggal' => $request->input('tanggal')[$i],
                'tempat' => $request->input('tempat')[$i],
            ]);
            $i++;
        }
        LogDetailProgram::create([
            "detail_program_id" => $detailProgram->id,
            "keterangan" => "Pembuatan Detail Program",
            "anggota_id" => auth()->user()->id,
        ]);

        return redirect()->route('viewDetailProgram', $detailProgram->id);
    }

    public function getFeedbackData(DetailProgram $detailProgram)
    {
        return response()->json(FeedbackDetailProgram::where('detail_program_id', $detailProgram->id)->with('anggota.jabatan')->get());
    }

    public function submitFeedback(FeedbackDetailProgramRequest $request)
    {
        $data = (($request))->validated();
        $data['anggota_id'] = auth()->user()->id;
        $feed = FeedbackDetailProgram::create($data);

        if (auth()->user()->jabatan->sirekat_group == 5) {
            Notifikasi::create([
                'type' => 2,
                'sirekat_group' => 1,
                'isi_plain' => auth()->user()->jabatan->nama . " baru saja memberikan Feedback di Detail Program " . $feed->detail_program->nama,
                'isi' => auth()->user()->jabatan->nama . " baru saja memberikan Feedback di <a href='" . route("viewDetailProgram", $data['detail_program_id']) . "'>Detail Program " . $feed->detail_program->nama . "</a>",
            ]);
        } else {
            Notifikasi::create([
                'type' => 2,
                'sirekat_group' => 5,
                'departemen_id' => $feed->detail_program->program->rkat->departemen_id,
                'isi_plain' => auth()->user()->jabatan->nama . " baru saja memberikan Feedback di Detail Program " . $feed->detail_program->nama,
                'isi' => auth()->user()->jabatan->nama . " baru saja memberikan Feedback di <a href='" . route("viewDetailProgram", $data['detail_program_id']) . "'>Detail Program " . $feed->detail_program->nama . "</a>",
            ]);
        }
        return redirect()->back();
    }

    public function getDataMonitoring(Request $request)
    {
        $d = $request->all();
        $data = DetailProgram::where('status', '>=', 0);

        if (array_key_exists('departemen', $d)) {
            if (strlen($d['departemen']) > 0) {
                $data = $data->whereHas('program', function ($q) use ($d) {
                    $q->whereHas('rkat', function ($q) use ($d) {
                        $q->whereHas('departemen', function ($q) use ($d) {
                            $q->where('nama', 'like', "%" . $d['departemen'] . "%");
                        });
                    });
                });
            }
        }

        if (array_key_exists('tanggal', $d)) {
            if (strlen($d['tanggal']) > 10) {
                $tanggal = explode(" to ", $d['tanggal']);
                $data = $data->whereHas('kegiatan', function ($q) use ($tanggal) {
                    $q->whereBetween('tanggal', $tanggal);
                });
            }
        }

        if (array_key_exists('program', $d)) {
            $data = $data->whereHas('program', function ($q) use ($d) {
                $q->where('nama', 'like', "%" . $d['program'] . "%");
            });
        }

        if (array_key_exists('status', $d)) {

            if ($d['status'] != -1) {
                $data = $data->where('status', $d['status']);
            }
        }

        if (array_key_exists('status_kegiatan', $d)) {
            if ($d['status_kegiatan'] != -1) {
                $data = $data->whereHas('kegiatan', function ($q) use ($d) {
                    $q->where('status', $d['status_kegiatan']);
                });
            }
        }

        if (array_key_exists('detail_program', $d)) {
            $data = $data->where('nama', 'like', "%" . $d['detail_program'] . "%");
        }
        if (array_key_exists('program_id', $d)) {
            $data = $data->where('program_id', $d['program_id']);
        }

        if (array_key_exists('rkat_id', $d)) {
            $data = $data->whereHas('program', function ($q) use ($d) {
                $q->where('rkat_id', $d['rkat_id']);
            });
        }
        $data = $data->orderBy('program_id', 'asc')->with(['pic:id,nama_lengkap', 'program.rkat.departemen']);
        $data = $data->paginate(15);

        return new DetailProgramResourceCollection(0, 1, $data);
    }

    public function getData(Request $request)
    {
        $d = $request->all();
        $data = DetailProgram::where('status', '>=', 0);

        if (array_key_exists('departemen', $d)) {
            if (strlen($d['departemen']) > 0) {
                $data = $data->whereHas('departemen', function ($q) use ($d) {
                    $q->where('nama', 'like', "%" . $d['departemen'] . "%");
                });
            }
        }

        if (array_key_exists('tanggal', $d)) {
            if (strlen($d['tanggal']) > 10) {
                $tanggal = explode(" to ", $d['tanggal']);

                $data = $data->whereHas('kegiatan', function ($q) use ($tanggal) {
                    $q->whereBetween('tanggal', $tanggal);
                });
            }
        }

        if (array_key_exists('program', $d)) {
            $data = $data->whereHas('program', function ($q) use ($d) {
                $q->where('nama', 'like', "%" . $d['program'] . "%");
            });
        }

        if (array_key_exists('status', $d)) {
            if ($d['status'] != -1) {
                $data = $data->where('status', $d['status']);
            }
        }

        if (array_key_exists('status_kegiatan', $d)) {
            if ($d['status_kegiatan'] != -1) {
                $data = $data->whereHas('kegiatan', function ($q) use ($d) {
                    $q->where('status', $d['status_kegiatan']);
                });
            }
        }

        if (array_key_exists('detail_program', $d)) {
            $data = $data->where('nama', 'like', "%" . $d['detail_program'] . "%");
        }
        if (array_key_exists('program_id', $d)) {
            $data = $data->where('program_id', $d['program_id']);
        }

        if (array_key_exists('rkat_id', $d)) {
            $data = $data->whereHas('program', function ($q) use ($d) {
                $q->where('rkat_id', $d['rkat_id']);
            });
        }
        $data = $data->orderBy('program_id', 'asc')->with('pic:id,nama_lengkap');
        $data = $data->paginate(15);

        return new DetailProgramResourceCollection(0, 1, $data);
    }

    public function getDataTimeline(Request $request)
    {
        return new DetailProgramResourceCollection(0, 1, DetailProgram::where('program_id', $request->input('program_id'))->where('status', '>=', 0)->orderBy('program_id', 'asc')->paginate(15));
    }

    public function getLogData(DetailProgram $detailProgram)
    {
        return response()->json(LogDetailProgram::where('detail_program_id', $detailProgram->id)->with('anggota.jabatan')->get());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DetailProgram  $detailProgram
     * @return \Illuminate\Http\Response
     */
    public function show(DetailProgram $detailProgram)
    {

        if (!$this->checkRule($detailProgram)) {
            return view('auth.notauthorize');
        }
        if (!LogViewDetailProgram::where('anggota_id', auth()->user()->id)->where('detail_program_id', $detailProgram->id)->first()) {
            LogViewDetailProgram::create([
                'anggota_id' => auth()->user()->id,
                'detail_program_id' => $detailProgram->id,
            ]);
        }
        return view('detail-program.view', ['detailProgram' => $detailProgram]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DetailProgram  $detailProgram
     * @return \Illuminate\Http\Response
     */
    public function edit(DetailProgram $detailProgram)
    {
        if (!$this->checkRule($detailProgram)) {
            return view('auth.notauthorize');
        }
        return view('detail-program.edit', ['detailProgram' => $detailProgram]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DetailProgram  $detailProgram
     * @return \Illuminate\Http\Response
     */
    public function editLaporanDetailProgram(Request $request, $id)
    {

        $laporanDetailProgram = LaporanDetailProgram::where('detail_program_id', $id)->firstOrFail();
        if (!$this->checkRule($laporanDetailProgram->detailProgram)) {
            return view('auth.notauthorize');
        }
        return view('detail-program.editLaporanDetailProgram', ['laporanDetailProgram' => $laporanDetailProgram]);
    }

    public function uploadLaporanProgram(EditLaporanRequest $request)
    {

        $data = (($request))->validated();

        $data['created_by'] = auth()->user()->id;
        if ($request->file('dokumen')) {

            $tujuan_upload = 'data_document';
            $file = $request->file('dokumen');
            $name = now()->timestamp . "_" . uniqid(12) . "." . $file->getClientOriginalExtension();
            $file->move($tujuan_upload, $name);
            $data['dokumen'] = $name;
        }

        if (array_key_exists('video_url', $data)) {
            $data['embed_url'] = str_replace('watch?v=', 'embed/', $data['video_url']);
        }

        $laporan = LaporanDetailProgram::find($request->input('id'));
        if (!$laporan) {
            $laporan = LaporanDetailProgram::create($data);
        } else {
            $laporan->update($data);
        }
        if ($request->input('dokumentasi')) {
            foreach ($request->input('dokumentasi') as $gambar) {
                GambarLaporan::create([
                    'laporan_id' => $laporan->id,
                    'image_url' => $gambar,
                ]);
            }
        }
        Notifikasi::create([
            'type' => 2,
            'sirekat_group' => 1,
            'isi' => auth()->user()->jabatan->nama . " baru saja mengupload Laporan Detail Program <a href='" . route("viewDetailProgram", $data['detail_program_id']) . "'>Detail Program " . $laporan->detail_program->nama . "</a> Mohon Berikan Penilaian dari Pencapaian Detail Program Tersebut.",
        ]);
        return redirect()->route('viewDetailProgram', ["detailProgram" => $laporan->detailProgram]);
    }

    public function laporan(Request $request, $id)
    {

        $laporanDetailProgram = LaporanDetailProgram::where('detail_program_id', $id)->first();
        if (!$this->checkRule($laporanDetailProgram->detailProgram)) {
            return view('auth.notauthorize');
        }
        if (!LogViewLaporanDetailProgram::where('anggota_id', auth()->user()->id)->where('laporan_detail_program_id', $laporanDetailProgram->id)->first()) {
            LogViewLaporanDetailProgram::create([
                'anggota_id' => auth()->user()->id,
                'laporan_detail_program_id' => $laporanDetailProgram->id,
            ]);
        }

        return view('detail-program.laporan', ['laporan' => $laporanDetailProgram]);
    }

    public function uploadLaporan(DetailProgram $detailProgram)
    {
        if (!$this->checkRule($detailProgram)) {
            return view('auth.notauthorize');
        }

        return view('detail-program.uploadLaporan', ['detailProgram' => $detailProgram]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DetailProgram  $detailProgram
     * @return \Illuminate\Http\Response
     */
    public function updateDetailProgram(DetailProgramRequest $request)
    {
        $req = $request->all();

        $data = (($request))->validated();

        $detailProgram = DetailProgram::findOrFail($req['id']);
        $detailProgram->update($data);
        Kegiatan::where('detail_program_id', $detailProgram->id)->delete();
        $i = 0;
        foreach ($req['tempat'] as $kegiatan) {
            Kegiatan::create([
                'detail_program_id' => $detailProgram->id,
                'tempat' => $req['tempat'][$i],
                'tanggal' => $req['tanggal'][$i]
            ]);
            $i++;
        }
        LogDetailProgram::create([
            "detail_program_id" => $detailProgram->id,
            "keterangan" => "Melakukan Perubahan Detail Program",
            "anggota_id" => auth()->user()->id,
        ]);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DetailProgram  $detailProgram
     * @return \Illuminate\Http\Response
     */
    public function destroy(DetailProgram $detailProgram)
    {
        //
    }
}
