<?php

Route::controller(Ermakk\MoonshineTableColorize\Controllers\ColorizeController::class)
    ->prefix('/rest/colorize')
    ->name('api.rest.colorize')
    ->group(function () {
        Route::post('', 'set')
            ->name('.set');
    });