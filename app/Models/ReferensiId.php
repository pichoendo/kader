<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferensiId extends Model
{
    use HasFactory;
    protected $fillable = [
        'departemen_id',
        'tahun',
        'type',
        'counter',
    ];
}
