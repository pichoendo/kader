<?php

namespace App\Observers;

use App\Models\LogRKAT;
use App\Models\Notifikasi;
use App\Models\RKAT;

class LogRKATObserver
{
    /**
     * Handle the LogRKAT "created" event.
     *
     * @param  \App\Models\LogRKAT  $logRKAT
     * @return void
     */
    public function created(LogRKAT $logRKAT)
    {
        $status = [1, 3, 4];
        $message = [
            0 => auth()->user()->jabatan->nama . " baru saja meminta untuk anda merevisi pengajuan RKAT anda",
            1 => auth()->user()->jabatan->nama . " baru saja menerima  pengajuan RKAT anda",
            2 => auth()->user()->jabatan->nama . " baru saja menolak pengajuan RKAT anda",
        ];
        $msg = $message[$logRKAT->keputusan];
        RKAT::find($logRKAT->rkat_id)->update(['status' => $status[$logRKAT->keputusan]]);
        Notifikasi::create([
            'type' => 2,
            'sirekat_group' => 5,
            'departemen_id' => RKAT::find($logRKAT->rkat_id)->departemen_id,
            'isi' => $msg,
        ]);

    }

    /**
     * Handle the LogRKAT "updated" event.
     *
     * @param  \App\Models\LogRKAT  $logRKAT
     * @return void
     */
    public function updated(LogRKAT $logRKAT)
    {

    }

    /**
     * Handle the LogRKAT "deleted" event.
     *
     * @param  \App\Models\LogRKAT  $logRKAT
     * @return void
     */
    public function deleted(LogRKAT $logRKAT)
    {
        //
    }

    /**
     * Handle the LogRKAT "restored" event.
     *
     * @param  \App\Models\LogRKAT  $logRKAT
     * @return void
     */
    public function restored(LogRKAT $logRKAT)
    {
        //
    }

    /**
     * Handle the LogRKAT "force deleted" event.
     *
     * @param  \App\Models\LogRKAT  $logRKAT
     * @return void
     */
    public function forceDeleted(LogRKAT $logRKAT)
    {
        //
    }
}
