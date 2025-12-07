<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RKAT extends Model
{
    use HasFactory;
    protected $table = "rkats";
    protected $fillable = [
        'departemen_id',
        'created_by',
        'tahun_anggaran',
        'dokumen_pengajuan',
        'status',
    ];

    protected $appends = [
        'anggaran',
        'progress',

    ];

    public function getAnggaranAttribute()
    {
        $ang = 0;
        foreach ($this->pokok_program as $program) {
            $ang += $program->anggaran;
        }
        return $ang;
    }
    public function departemen()
    {
        return $this->belongsTo(Departemen::class)->select('id', 'nama');
    }

    public function pokok_program()
    {
        return $this->hasMany(Program::class, 'rkat_id');
    }
    public function viewBy()
    {
        return $this->hasMany(LogViewRKAT::class, 'rkat_id');
    }

    public function getProgressAttribute()
    {
        return $this->pokok_program->where('status', 2)->count() * 100 / ($this->pokok_program->count() > 0 ? $this->pokok_program->count() : 1);
    }

    public function detail_program_count(int $type)
    {
        $count = 0;
        foreach ($this->pokok_program as $data) {
            if ($type == 0) {
                $count += $data->detail_program_count(0);
            } else {
                $count += $data->detail_program_count(5);
            }

        }
        return $count;
    }

}
