<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogRKAT extends Model
{
    use HasFactory;
    protected $table = "log_rkats";
    protected $fillable = [
        'created_by',
        'keputusan',
        'rkat_id',
        'catatan',
    ];

    public function rkat()
    {
        return $this->belongsTo(RKAT::class);
    }

}
