<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iuran extends Model
{
    use HasFactory;
    protected $fillable = [
        'periode_id',
        'anggota_id',
        'penerimaan',
        'total',
        'status',
        'transaksi_id'
    ];
}
