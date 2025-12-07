<?php

namespace App\Http\Controllers;

use App\Http\Resources\JenjangResourceCollection;
use App\Models\Jenjang;
use Illuminate\Http\Request;
use View;

class JenjangController extends Controller
{
    private $title = "Jenjang";

    public function __construct()
    {
        View::share('title', $this->title);
    }

    public function getDatas(Request $request)
    {
        $d = $request->all();
        $data = Jenjang::query();
        if (array_key_exists('nama', $d)) {
            if (strlen($d['nama']) > 0) {
                $data = $data->where('nama', 'like', '%' . $d['nama'] . '%');
            }

        }
        $data = $data->with(['jenjang_setelahnya','jenjang_sebelumnya'])->paginate(15);
        return new JenjangResourceCollection(0, 1, $data);
    }

    public function getData(Request $request)
    {
        $d = $request->all();
        $data = Jenjang::where('id','>',0);
        if (array_key_exists('nama', $d)) {
            if (strlen($d['nama']) > 0) {
                $data = $data->where('nama', 'like', '%' . $d['nama'] . '%');
            }

        }
        $data = $data->with(['jenjang_setelahnya','jenjang_sebelumnya'])->paginate(15);
        return new JenjangResourceCollection(0, 1, $data);
    }
    public function create(){
        return view('jenjang/create');
    }
    public function index(){
        return view('jenjang/index');
    }

    public function view(Jenjang $jenjang){
        return view('jenjang/view',['jenjang'=>$jenjang]);
    }
    public function delete(Request $req){
        Jenjang::find($req->input('id'))->delete();
        return redirect()->route('jenjang');
    }
    public function update(Request $reqeust){
        $d=$reqeust->all();
        Jenjang::find($d['id'])->update([
            'nama'=>$d['nama'],
            'jenjang_sebelumnya_id'=>$d['jenjang_sebelumnya_id'],
            'jenjang_setelahnya_id'=>$d['jenjang_setelahnya_id'],

        ]);
        return redirect()->route('jenjang');
    }

    public function save(Request $reqeust){
        $d=$reqeust->all();
        Jenjang::create([
            'nama'=>$d['nama'],
            'jenjang_sebelumnya_id'=>$d['jenjang_sebelumnya_id'],
            'jenjang_setelahnya_id'=>$d['jenjang_setelahnya_id'],

        ]);
        return redirect()->route('jenjang');
        
    }

    public function edit(){
        
    }



}
