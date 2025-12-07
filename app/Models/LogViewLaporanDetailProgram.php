<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogViewLaporanDetailProgram extends Model
{
    use HasFactory;
    protected $fillable = [
        'anggota_id',
        'laporan_detail_program_id',
    ];
    public function anggota()
    {
        return $this->belongsTo(Anggota::class)->select('id', 'nama_lengkap', 'dpd_id', 'organisasi_id', 'jabatan_id', 'departemen_id');
    }
}
