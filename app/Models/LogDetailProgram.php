<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogDetailProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'anggota_id',
        'keterangan',
        'detail_program_id',
        'catatan',
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

    public function anggota()
    {
        return $this->belongsTo(Anggota::class)->select('id', 'nama_lengkap', 'jabatan_id');
    }
}
