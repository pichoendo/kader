<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesertaPendidikan extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_anggota',
        'id_pendidikan_kader',
        'status',
        'judul_task'
    ];
    public function anggota()
    {
        return $this->belongsTo(Anggota::class, "id_anggota")->select('id', 'kode', 'nama_lengkap');
    }

    public function pendidikan_kader()
    {
        return $this->belongsTo(PendidikanKader::class);
    }
}
