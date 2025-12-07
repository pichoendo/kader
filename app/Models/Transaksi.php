<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $table = "transaksi";
    protected $fillable = [
        'kode',
        'anggota_id',
        'payment_method',
        'tagihan',
        'status',
        'penerimaan',
        'type'
    ];

    public function anggota(){
        return $this->belongsTo(Anggota::class)->select('id','nama_lengkap','dpd_id','organisasi_id');
    }

}
