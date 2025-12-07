<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifikasiReaded extends Model
{
    use HasFactory;
    protected $table = "notifikasi_read";
    protected $fillable = [
        'anggota_id',
        'notifikasi_id',
    ];
    public function notifikasi()
    {
        return $this->belongsTo(Notifikasi::class);
    }
}
