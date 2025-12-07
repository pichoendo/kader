<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GambarLaporan extends Model
{
    use HasFactory;
    protected $fillable = [
        'laporan_id',
        'image_url',
    ];
}
