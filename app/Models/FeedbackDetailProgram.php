<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackDetailProgram extends Model
{
    use HasFactory;
    protected $fillable = [
        'detail_program_id',
        'anggota_id',
        'feedback',
    ];
    public function anggota()
    {
        return $this->belongsTo(Anggota::class)->select('id', 'nama_lengkap', 'jabatan_id');
    }
    public function detail_program()
    {
        return $this->belongsTo(DetailProgram::class);
    }
}
