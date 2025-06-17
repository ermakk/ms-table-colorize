<?php

namespace Ermakk\MoonshineTableColorize\Controllers;

use Ermakk\MoonshineTableColorize\Requests\ColorizeRequest;
use Illuminate\Support\Facades\Session;
use MoonShine\Laravel\Http\Controllers\MoonShineController;

class ColorizeController extends MoonShineController
{
    public function set(
        ColorizeRequest $request
    )
    {
        $resource = $request->get('_resource');
        $component = $request->get('_listComponentName');
        session()->remove('colorize_sets.'.$resource.'.'.$component);
        session(['colorize_sets.'.$resource.'.'.$component => $request->get('colorize')]);

    }

}
