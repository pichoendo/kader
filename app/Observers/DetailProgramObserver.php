<?php

namespace App\Observers;

use App\Library\Libs;
use App\Models\DetailProgram;
use App\Models\LogViewDetailProgram;

class DetailProgramObserver
{
    /**
     * Handle the DetailProgram "created" event.
     *
     * @param  \App\Models\DetailProgram  $detailProgram
     * @return void
     */
    public function created(DetailProgram $detailProgram)
    {
        $detailProgram->kode = Libs::generateDetailProgramCode($detailProgram->program->rkat->departemen_id, $detailProgram->program->rkat->tahun_anggaran);
        $detailProgram->saveQuietly();
    }

    /**
     * Handle the DetailProgram "updated" event.
     *
     * @param  \App\Models\DetailProgram  $detailProgram
     * @return void
     */
    public function updated(DetailProgram $detailProgram)
    {
        if ($detailProgram->getOriginal('poin') != $detailProgram->poin) {
            $program = $detailProgram->program;
            $program->poin = $program->detail_program->sum('poin') / $program->detail_program->count();
            $program->save();
        }
        LogViewDetailProgram::where('detail_program_id', $detailProgram->id)->delete();
    }

    /**
     * Handle the DetailProgram "deleted" event.
     *
     * @param  \App\Models\DetailProgram  $detailProgram
     * @return void
     */
    public function deleted(DetailProgram $detailProgram)
    {
        //
    }

    /**
     * Handle the DetailProgram "restored" event.
     *
     * @param  \App\Models\DetailProgram  $detailProgram
     * @return void
     */
    public function restored(DetailProgram $detailProgram)
    {
        //
    }

    /**
     * Handle the DetailProgram "force deleted" event.
     *
     * @param  \App\Models\DetailProgram  $detailProgram
     * @return void
     */
    public function forceDeleted(DetailProgram $detailProgram)
    {
        //
    }
}
