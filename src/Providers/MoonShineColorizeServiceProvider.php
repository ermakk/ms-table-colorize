<?php

declare(strict_types = 1);

namespace Ermakk\MoonShineTableColorize\Providers;

use Ermakk\MoonshineUserSpoofing\Services\Settings;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class MoonShineColorizeServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/moonshine-table-colorize.php', 'moonshine-table-colorize');
    }

    public function boot(Kernel $kernel): void
    {


        // Configuration
        $this->publishes(
            [
                __DIR__.'/../../config/moonshine-table-colorize.php' => config_path('moonshine-table-colorize.php'),
            ],
            [
                'moonshine-table-colorize',
                'config',
            ]
        );

        // Localization
        $this->publishes(
            [
                __DIR__.'/../../lang' => $this->app->langPath('vendor/moonshine-table-colorize')
            ],
            [
                'moonshine-table-colorize',
                'lang',
            ]
        );
        
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        
        $this->loadTranslationsFrom(__DIR__ . '/../../lang', 'moonshine-table-colorize');
    }



}