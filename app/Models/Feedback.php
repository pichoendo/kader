<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;
    protected $table = 'feedback_sikader';
    protected $fillable = [
        'anggota_id',
        'feedback',
        'status',
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class)->select('id', 'nama_lengkap', 'jabatan_id', 'photo');
    }
}
