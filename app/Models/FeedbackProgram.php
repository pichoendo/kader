<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackProgram extends Model
{
    use HasFactory;
    protected $fillable = [
        'program_id',
        'anggota_id',
        'feedback',
    ];
    public function anggota()
    {
        return $this->belongsTo(Anggota::class)->select('id', 'nama_lengkap', 'jabatan_id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
