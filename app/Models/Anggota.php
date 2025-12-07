<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Anggota extends Authenticatable
{
    use HasFactory;
    protected $table = "anggota";

    protected $fillable = [
        'is_kader',
        'jenjang_kaderisasi_id'
    ];
    public function dpd()
    {
        return $this->belongsTo(DPD::class)->select('id', 'nama');
    }

    public function departemen()
    {
        return $this->belongsTo(Departemen::class)->select('id', 'nama');
    }

    public function status_kader()
    {
        return $this->belongsTo(Jenjang::class, 'jenjang_kaderisasi_id');
    }
    public function historiKaderisasi()
    {
        return $this->hasMany(LogKaderisasi::class, 'anggota_id');
    }
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class)->select('id', 'nama', 'sikader_group');
    }


    public function organisasi()
    {
        return $this->belongsTo(Organisasi::class)->select('id', 'nama');
    }
}
