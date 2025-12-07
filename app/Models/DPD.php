<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DPD extends Model
{
    use HasFactory;
    protected $table = 'dpd';

    public function anggota()
    {
        return $this->hasMany(Anggota::class,'dpd_id');
    }
    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class,'province_id');
    }
}
