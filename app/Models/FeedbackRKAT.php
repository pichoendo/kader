<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackRKAT extends Model
{
    use HasFactory;
    protected $table = "feedback_rkats";
    protected $fillable = [
        'rkat_id',
        'anggota_id',
        'feedback',
    ];

    public function rkat()
    {
        return $this->belongsTo(RKAT::class)->select('id', 'departemen_id');
    }

    public function anggota()
    {
        return $this->belongsTo(Anggota::class)->select('id', 'nama_lengkap', 'jabatan_id');
    }
}
