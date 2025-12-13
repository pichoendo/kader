<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendidikanKader extends Model
{
    use HasFactory;
    protected $fillable = [
        'kode',
        'tahun',
        'jenjang_kaderisasi_id',
        'status',
    ];

    public function peserta()
    {
        return $this->hasMany(PesertaPendidikan::class, 'id_pendidikan_kader');
    }

    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class, 'jenjang_kaderisasi_id')->select('id', 'nama');
    }
}
