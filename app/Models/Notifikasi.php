<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;
    protected $table = "notifikasi";
    protected $hidden = ['notifikasiRead'];
    protected $appends = [
        'readedByMe',
    ];

    protected $fillable = [
        'type',
        'anggota_id',
        'sirekat_group',
        'sitari_group',
        'dpd_id',
        'dpw_id',
        'departemen_id',
        'isi',
    ];
    public function notifikasiRead()
    {
        return $this->hasMany(NotifikasiReaded::class)->select('id', 'anggota_id');
    }

    public function getReadedByMeAttribute()
    {
        return $this->notifikasiRead->where('anggota_id', auth()->user()->id)->count() == 1;
    }
}
