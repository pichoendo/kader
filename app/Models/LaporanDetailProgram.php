<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanDetailProgram extends Model
{
    use HasFactory;
    protected $fillable = [
        'created_by',
        'serapan',
        'detail_program_id',
        'dokumen',
        'embed_url',
        'video_url',
        'poin',
    ];

    public function detailProgram()
    {
        return $this->belongsTo(DetailProgram::class, 'detail_program_id');
    }

    public function viewBy()
    {
        return $this->hasMany(LogViewLaporanDetailProgram::class, 'laporan_detail_program_id');
    }

    public function gambar()
    {
        return $this->hasMany(GambarLaporan::class, 'laporan_id');
    }

}
