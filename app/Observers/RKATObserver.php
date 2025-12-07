<?php

namespace App\Observers;

use App\Library\Libs;
use App\Models\LogViewRKAT;
use App\Models\RKAT;

class RKATObserver
{
    /**
     * Handle the RKAT "created" event.
     *
     * @param  \App\Models\RKAT  $rKAT
     * @return void
     */
    public function created(RKAT $rkat)
    {
        $rkat->kode = Libs::generateRKATCode($rkat->departemen_id, $rkat->tahun_anggaran);
        $rkat->saveQuietly();
    }

    /**
     * Handle the RKAT "updated" event.
     *
     * @param  \App\Models\RKAT  $rKAT
     * @return void
     */
    public function updated(RKAT $rKAT)
    {

        if ($rKAT->getOriginal('status') < 4) {
            if ($rKAT->status == 4) {
                if ($rKAT->pokok_program) {
                    foreach ($rKAT->pokok_program as $program) {
                        $program->update(['status' => 2]);
                    }
                }

            }
        }
        LogViewRKAT::where('rkat_id', $rKAT->id)->delete();

    }

    /**
     * Handle the RKAT "deleted" event.
     *
     * @param  \App\Models\RKAT  $rKAT
     * @return void
     */
    public function deleted(RKAT $rKAT)
    {
        //
    }

    /**
     * Handle the RKAT "restored" event.
     *
     * @param  \App\Models\RKAT  $rKAT
     * @return void
     */
    public function restored(RKAT $rKAT)
    {
        //
    }

    /**
     * Handle the RKAT "force deleted" event.
     *
     * @param  \App\Models\RKAT  $rKAT
     * @return void
     */
    public function forceDeleted(RKAT $rKAT)
    {
        //
    }
}
