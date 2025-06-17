<?php

Route::controller(Ermakk\MoonshineTableColorize\Controllers\ColorizeController::class)
    ->middleware(config('moonshine-table-colorize.middleware', ['web', 'auth']))
    ->prefix('/rest/colorize')
    ->name('api.rest.colorize')
    ->group(function () {
        Route::post('', 'set')
            ->name('.set');
    });