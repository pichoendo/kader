<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedbackProgramRequest;
use App\Http\Requests\PokokProgramRequest;
use App\Http\Resources\ProgramResourceCollection;
use App\Models\DetailProgram;
use App\Models\FeedbackProgram;
use App\Models\LogViewProgram;
use App\Models\Notifikasi;
use App\Models\PokokProgram;
use App\Models\Program;
use Illuminate\Http\Request;
use View;

class ProgramController extends Controller
{

    public function checkRule($program)
    {
        if (auth()->user()->jabatan->sirekat_group != 1) {
            if (auth()->user()->departemen_id != $program->rkat->departemen_id) {
                return false;
            }
        }
        return true;
    }

    private $title = "Program";

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

    public function getFeedbackData(Program $program)
    {
        return response()->json(FeedbackProgram::where('program_id', $program->id)->with('anggota.jabatan')->get());
    }

    public function submitFeedback(FeedbackProgramRequest $request)
    {
        $data = (($request))->validated();
        $data['anggota_id'] = auth()->user()->id;
        $feed = FeedbackProgram::create($data);

        if (auth()->user()->jabatan->sirekat_group == 5) {
            Notifikasi::create([
                'type' => 2,
                'sirekat_group' => 1,
                'isi' => auth()->user()->jabatan->nama . " baru saja memberikan Feedback di <a href='" . route("viewProgram", $data['program_id']) . "'>Program " . $feed->program->nama . "</a>",
            ]);
        } else {
            Notifikasi::create([
                'type' => 2,
                'sirekat_group' => 5,
                'departemen_id' => $feed->program->rkat->departemen_id,
                'isi' => auth()->user()->jabatan->nama . " baru saja memberikan Feedback di <a href='" . route("viewProgram", $data['program_id']) . "'> Program " . $feed->program->nama . "</a>",
            ]);
        }
        return redirect()->back();
    }

    public function getData(Request $request)
    {
        $d = $request->all();
        $data = Program::where('status', '>', 0);

        if (array_key_exists('departemen', $d)) {
            if (strlen($d['departemen']) > 0) {
                $data = $data->whereHas('departemen', function ($q) use ($d) {
                    $q->where('nama', 'like', "%" . $d['departemen'] . "%");
                });
            }

        }

        if (array_key_exists('rkat_id', $d)) {
            $data = $data->where('rkat_id', $d['rkat_id']);
        }
        //$data = $data->;
        $data = $data->paginate(15);

        return new ProgramResourceCollection(0, 1, $data);
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
    public function store(PokokProgramRequest $request)
    {
        $data = (($request))->validated();
        $pokokProgram = Program::create($data);
        $dp = DetailProgram::create(['program_id' => $pokokProgram->id, 'is_dummy' => 1]);
        return redirect()->route("viewProgram", $pokokProgram->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PokokProgram  $pokokProgram
     * @return \Illuminate\Http\Response
     */
    public function show(Program $pokokProgram)
    {
        if (!$this->checkRule($pokokProgram)) {
            return view('auth.notauthorize');
        }
        if (!LogViewProgram::where('anggota_id', auth()->user()->id)->where('program_id', $pokokProgram->id)->first()) {
            LogViewProgram::create([
                'anggota_id' => auth()->user()->id,
                'program_id' => $pokokProgram->id,
            ]);
        }
        return view('program.view', ['program' => $pokokProgram]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PokokProgram  $pokokProgram
     * @return \Illuminate\Http\Response
     */
    public function edit(Program $program)
    {
        if (!$this->checkRule($program)) {
            return view('auth.notauthorize');
        }
        return view('program.edit', ['program' => $program]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PokokProgram  $pokokProgram
     * @return \Illuminate\Http\Response
     */
    public function update(PokokProgramRequest $request)
    {
        $req = $request->all();

        $pokokProgram = Program::findOrFail($req['id']);
        if (!$this->checkRule($pokokProgram)) {
            return view('auth.notauthorize');
        }
        $data = (($request))->validated();
        $pokokProgram->update($data);
        return redirect()->route("viewProgram", $pokokProgram->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PokokProgram  $pokokProgram
     * @return \Illuminate\Http\Response
     */
    public function destroy(Program $pokokProgram)
    {
        //
    }
}
