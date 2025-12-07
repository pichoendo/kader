<?php

namespace App\Library;

use App\Models\Departemen;
use App\Models\ReferensiId;

class Libs
{

    public static function findCode($dept_id, $tahun, $type)
    {
        $data = ReferensiId::where('departemen_id', $dept_id)->where('tahun', $tahun)->where('type', $type)->first();
        if (!$data) {
            $data = ReferensiId::create([
                'departemen_id' => $dept_id,
                'tahun' => $tahun,
                'type' => $type,
                'counter' => 1,
            ]);
        }
        $kode = $data->counter;
        $data->counter++;
        $data->save();
        return $kode;
    }

    public static function generateRKATCode($dep_id, $tahun_anggaran)
    {
        return "RKAT/" . Departemen::find($dep_id)->singkatan . "/" . $tahun_anggaran;
    }

    public static function generateProgramCode($dep_id, $tahun_anggaran)
    {
        return "PROG/" . Departemen::find($dep_id)->singkatan . "/" . $tahun_anggaran . "/" . Libs::findCode($dep_id, $tahun_anggaran, 2);
    }

    public static function generateDetailProgramCode($dep_id, $tahun_anggaran)
    {
        return "DPROG/" . Departemen::find($dep_id)->singkatan . "/" . $tahun_anggaran . "/" . Libs::findCode($dep_id, $tahun_anggaran, 3);
    }

    public static function generateNameForFile($name)
    {
        return now()->format('Ymdhis') . "_" . str_replace(' ', '_', $name);
    }
}
