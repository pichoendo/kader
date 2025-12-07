<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusKaderisasiAnggota extends Model
{
    use HasFactory;
    protected $table = "status_kaderisasis";
    protected $fillable = [
        'created_by',
        'anggota_id',
        'jenjang_kaderisasi_id',
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }

    public function jenjang_kaderisasi()
    {
        return $this->belongsTo(Jenjang::class,'jenjang_kaderisasi_id');
    }
}
