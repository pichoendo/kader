<?php

namespace App\Providers;

use App\Models\DetailProgram;
use App\Models\Kegiatan;
use App\Models\LaporanDetailProgram;
use App\Models\LogRKAT;
use App\Models\Program;
use App\Models\RKAT;
use App\Observers\DetailProgramObserver;
use App\Observers\KegiatanObserver;
use App\Observers\LaporanDetailProgramObserver;
use App\Observers\LogRKATObserver;
use App\Observers\ProgramObserver;
use App\Observers\RKATObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        LaporanDetailProgram::observe(LaporanDetailProgramObserver::class);
        Kegiatan::observe(KegiatanObserver::class);
        RKAT::observe(RKATObserver::class);
        DetailProgram::observe(DetailProgramObserver::class);
        Program::observe(ProgramObserver::class);
        LogRKAT::observe(LogRKATObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
