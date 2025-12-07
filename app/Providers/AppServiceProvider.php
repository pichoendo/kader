<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('currency', function ($expression) {
            return "Rp. <?php echo number_format($expression,0,',','.'); ?>";
        });
        Blade::directive('inisial', function ($name) {
            $nameParts = explode(' ', trim($name));
            $firstName = array_shift($nameParts);
            $lastName = array_pop($nameParts);
            return (mb_substr($firstName, 0, 1) . mb_substr($lastName, 0, 1));
        });
    }
}
