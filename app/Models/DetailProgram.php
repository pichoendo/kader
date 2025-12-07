<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailProgram extends Model
{
    use HasFactory;
    protected $fillable = [
        'program_id',
        'nama',
        'volume',
        'anggaran',
        'pic_id',
        'tahapan',
        'is_dummy',
        'status',
        'poin_penilaian_pencapaian_outcome',
    ];

    protected $appends = [
        'kegiatanlist',
        'programlabel',
        'kegiatanOnTheWay',
        'kegiatanTimeline',
    ];
    public function tanggalKegiatanAkhir()
    {
        $this->kegiatanAkhir;
    }
    public function getKegiatanTimelineAttribute()
    {
        $months = $this->kegiatan->groupBy(function ($d) {
            return Carbon::parse($d->tanggal)->format('M');
        });
        return $months;
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function getProgramlabelAttribute()
    {
        $text = "<a href=" . route('viewProgram', $this->program->id) . " class='text-uppercase'><strong>" . $this->program->kode . "</strong></a><br><br>" . $this->program->nama;
        return $text;
    }

    public function pic()
    {
        return $this->belongsTo(Anggota::class, 'pic_id');
    }

    public function viewBy()
    {
        return $this->hasMany(LogViewDetailProgram::class, 'detail_program_id');
    }

    public function kegiatan()
    {
        return $this->hasMany(Kegiatan::class)->select('id', 'tempat', 'tanggal', 'status')->orderBy('id', 'asc');
    }
    public function kegiatanAkhir()
    {
        return $this->hasMany(Kegiatan::class)->select('id', 'tempat', 'tanggal', 'status')->orderBy('tanggal', 'desc');
    }
    public function getKegiatanlistAttribute()
    {
        $text = "<ol>";
        foreach ($this->kegiatan as $data) {
            $text .= "<li class='small'>" . $data->tanggal . ", " . $data->tempat . "</li>";
        }
        $text .= "</ol>";
        return $text;
    }
    public function getKegiatanOnTheWayAttribute()
    {
        return $this->kegiatan->where('status', '<', 3)->whereBetween('tanggal', [now()->subDay(1), now()->addDays(3)]);

    }
}
