<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogViewRKAT extends Model
{
    use HasFactory;
    protected $table = "log_view_rkats";
    protected $fillable = [
        'anggota_id',
        'rkat_id',
    ];
    public function anggota()
    {
        return $this->belongsTo(Anggota::class)->select('id', 'nama_lengkap', 'dpd_id', 'organisasi_id', 'jabatan_id', 'departemen_id');
    }
}
