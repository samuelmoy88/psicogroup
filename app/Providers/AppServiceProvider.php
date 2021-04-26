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
        Blade::directive('money', function ($money) {
            return "<?= floatval(number_format($money, 2)); ?>";
        });

        Blade::directive('transition', function ($transitionDirectives) {
            $directives = "";

            foreach (explode(',', $transitionDirectives) as $directive) {
                $directives .= "x-transition:$directive ";
            }

            return "<?= '$directives'; ?>";
        });
    }
}
