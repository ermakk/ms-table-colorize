<?php

namespace Ermakk\MoonshineTableColorize\Requests;



use MoonShine\Laravel\Http\Requests\MoonShineFormRequest;

class ColorizeRequest extends MoonShineFormRequest
{

    public function rules(): array
    {
        return [
            '_resource' => ['required', 'string'],
            '_listComponentName' => ['required', 'string'],
            'colorize' => ['nullable', 'array'],
            'colorize.*.sourceColumn' => ['required', 'string'],
            'colorize.*.target.column' => ['nullable', 'string'],
            'colorize.*.color' => ['required', 'string'],
            'colorize.*.operator' => ['required', 'string'],
            'colorize.*.target.value' => ['nullable', 'string'],
            'colorize.*.target.bool_value' => ['nullable', 'string'],
            'colorize.*.target.type' => ['required', 'string'],
        ];
    }

}
