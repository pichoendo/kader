<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jenjang extends Model
{
    use HasFactory;
    protected $table = "jenjang_kaderisasis";
    protected $fillable = [
        'nama',
        'jenjang_setelahnya_id',
        'jenjang_sebelumnya_id',
    ];

    public function jenjang_sebelumnya()
    {
        return $this->belongsTo(Jenjang::class,'jenjang_sebelumnya_id')->select('id', 'nama');
    }

    public function jenjang_setelahnya()
    {
        return $this->belongsTo(Jenjang::class,'jenjang_setelahnya_id')->select('id', 'nama');
    }
}
