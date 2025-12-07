<?php

namespace App\Observers;

use App\Models\DetailProgram;
use App\Models\Kegiatan;

class KegiatanObserver
{
    /**
     * Handle the Kegiatan "created" event.
     *
     * @param  \App\Models\Kegiatan  $kegiatan
     * @return void
     */
    public function created(Kegiatan $kegiatan)
    {
        //
    }

    /**
     * Handle the Kegiatan "updated" event.
     *
     * @param  \App\Models\Kegiatan  $kegiatan
     * @return void
     */
    public function updated(Kegiatan $kegiatan)
    {
        $detail = DetailProgram::findOrFail($kegiatan->detail_program_id);
        if (Kegiatan::where('detail_program_id', $detail->id)->where('status', '<', 3)->count() == 0) {
            $detail->update(['status' => 2]);
        }
    }

    /**
     * Handle the Kegiatan "deleted" event.
     *
     * @param  \App\Models\Kegiatan  $kegiatan
     * @return void
     */
    public function deleted(Kegiatan $kegiatan)
    {
        //
    }

    /**
     * Handle the Kegiatan "restored" event.
     *
     * @param  \App\Models\Kegiatan  $kegiatan
     * @return void
     */
    public function restored(Kegiatan $kegiatan)
    {
        //
    }

    /**
     * Handle the Kegiatan "force deleted" event.
     *
     * @param  \App\Models\Kegiatan  $kegiatan
     * @return void
     */
    public function forceDeleted(Kegiatan $kegiatan)
    {
        //
    }
}
