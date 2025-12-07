<?php

namespace App\Observers;

use App\Library\Libs;
use App\Models\LogViewProgram;
use App\Models\Program;

class ProgramObserver
{
    /**
     * Handle the Program "created" event.
     *
     * @param  \App\Models\Program  $prgoram
     * @return void
     */
    public function created(Program $prgoram)
    {
        $prgoram->kode = Libs::generateProgramCode($prgoram->rkat->departemen_id, $prgoram->rkat->tahun_anggaran);
        $prgoram->saveQuietly();

    }

    /**
     * Handle the Program "updated" event.
     *
     * @param  \App\Models\Program  $prgoram
     * @return void
     */
    public function updated(Program $prgoram)
    {
        if ($prgoram->getOriginal('status') < 2) {
            if ($prgoram->status == 2) {
                if ($prgoram->detail_program) {
                    foreach ($prgoram->detail_program as $detailProgram) {
                        $detailProgram->update(['status' => 2]);
                    }
                }

            }
        }
        LogViewProgram::where('program_id', $prgoram->id)->delete();
    }

    /**
     * Handle the Program "deleted" event.
     *
     * @param  \App\Models\Program  $prgoram
     * @return void
     */
    public function deleted(Program $prgoram)
    {
        //
    }

    /**
     * Handle the Program "restored" event.
     *
     * @param  \App\Models\Program  $prgoram
     * @return void
     */
    public function restored(Program $prgoram)
    {
        //
    }

    /**
     * Handle the Program "force deleted" event.
     *
     * @param  \App\Models\Program  $prgoram
     * @return void
     */
    public function forceDeleted(Program $prgoram)
    {
        //
    }
}
