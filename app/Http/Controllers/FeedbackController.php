<?php

namespace App\Http\Controllers;

use App\Http\Resources\AnggotaResourceCollection;
use App\Models\Feedback;
use Illuminate\Http\Request;
use View;

class FeedbackController extends Controller
{
    private $title = "Feedback";

    public function __construct()
    {
        View::share('title', $this->title);
    }


    public function getData(Request $request)
    {
        $d = $request->all();
        $data = Feedback::where('id', '>', 0);
        $data = $data->with(['anggota.jabatan'])->paginate(15);
        return new AnggotaResourceCollection(0, 1, $data);
    }

    public function index()
    {
        return view('feedback.index');
    }


    public function delete(Request $req)
    {
        Feedback::find($req->input('id'))->delete();
        return redirect()->route('feedback');
    }

    public function update(Request $reqeust)
    {
        $d = $reqeust->all();
        Feedback::find($d['id'])->update($d);
        return redirect()->route('feedback');
    }

    public function save(Request $reqeust)
    {
        $d = $reqeust->all();
        $d['anggota_id'] = auth()->user()->id;
        Feedback::create($d);
        return redirect()->route('feedback');
    }

    public function edit()
    {
    }
}
