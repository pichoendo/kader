<?php

namespace App\Observers;

use App\Models\LaporanDetailProgram;
use App\Models\LogViewLaporanDetailProgram;

class LaporanDetailProgramObserver
{
    /**
     * Handle the LaporanDetailProgram "created" event.
     *
     * @param  \App\Models\LaporanDetailProgram  $laporanDetailProgram
     * @return void
     */
    public function created(LaporanDetailProgram $laporanDetailProgram)
    {
        $laporanDetailProgram->detailProgram->update(['status' => 4]);
    }

    /**
     * Handle the LaporanDetailProgram "updated" event.
     *
     * @param  \App\Models\LaporanDetailProgram  $laporanDetailProgram
     * @return void
     */
    public function updated(LaporanDetailProgram $laporanDetailProgram)
    {
        LogViewLaporanDetailProgram::where('laporan_detail_program_id', $laporanDetailProgram->id)->delete();
    }

    /**
     * Handle the LaporanDetailProgram "deleted" event.
     *
     * @param  \App\Models\LaporanDetailProgram  $laporanDetailProgram
     * @return void
     */
    public function deleted(LaporanDetailProgram $laporanDetailProgram)
    {
        //
    }

    /**
     * Handle the LaporanDetailProgram "restored" event.
     *
     * @param  \App\Models\LaporanDetailProgram  $laporanDetailProgram
     * @return void
     */
    public function restored(LaporanDetailProgram $laporanDetailProgram)
    {
        //
    }

    /**
     * Handle the LaporanDetailProgram "force deleted" event.
     *
     * @param  \App\Models\LaporanDetailProgram  $laporanDetailProgram
     * @return void
     */
    public function forceDeleted(LaporanDetailProgram $laporanDetailProgram)
    {
        //
    }
}
