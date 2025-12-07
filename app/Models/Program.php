<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;
    protected $fillable = [
        'rkat_id',
        'nama',
        'keterangan',
        'status',
    ];

    protected $appends = [
        'anggaran',
        'progress',

    ];

    public function getProgressAttribute()
    {
        $count = $this->detail_program_count(0);
        return ($this->detail_program_count(2) * 100) / ($count > 0 ? $count : 1);
    }

    public function getAnggaranAttribute()
    {
        return $this->detail_program()->sum('anggaran');
    }

    public function viewBy()
    {
        return $this->hasMany(LogViewProgram::class, 'program_id');
    }

    public function rkat()
    {
        return $this->belongsTo(RKAT::class, 'rkat_id');
    }

    public function detail_program()
    {
        return $this->hasMany(DetailProgram::class);
    }
    public function anggaran_program()
    {
        return $this->detail_program()->sum('anggaran');
    }
    public function detail_program_count(int $type)
    {
        if ($type == 0) {
            return $this->detail_program()->count();
        } else {
            return $this->detail_program()->where('status', $type)->count();
        }

    }
}
