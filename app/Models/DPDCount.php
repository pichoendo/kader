<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DPDCount extends Model
{
    use HasFactory;
    protected $table = 'dpd';
    protected $appends = [
        'counter'
    ];
    public function getCounterAttribute()
    {
        return  $months = $this->anggotax->makeHidden('notifikasi')->pluck("total","jenjang_kaderisasi_id");
    }
   
    public function anggota()
    {
        return $this->hasMany(Anggota::class,'dpd_id');
    }
    public function anggotax()
    {
        return $this->hasMany(Anggota::class,'dpd_id')->where('is_kader',1)->select('jenjang_kaderisasi_id',DB::raw('count(*) as total'))->groupBy('jenjang_kaderisasi_id');
    }
    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class,'province_id');
    }
}
