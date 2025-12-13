<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DateTimeInterface;

class LogKaderisasi extends Model
{
    use HasFactory;
    protected $table = "log_kaderisasis";
    protected $fillable = [
        'created_by',
        'anggota_id',
        'jenjang_kaderisasi_id',
        'tempat',
        'tanggal',
        'keterangan'
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function jenjang_kaderisasi()
    {
        return $this->belongsTo(Jenjang::class, 'jenjang_kaderisasi_id');
    }
}
