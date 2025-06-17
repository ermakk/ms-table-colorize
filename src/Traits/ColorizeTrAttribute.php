<?php

namespace Ermakk\MoonshineTableColorize\Traits;

use Ermakk\MoonshineTableColorize\Components\ColorizeButton;
use Ermakk\MoonshineTableColorize\Enums\TypeFieldColorize;
use Ermakk\MoonshineTableColorize\Resources\Admin\User\UserResource;
use Closure;
use Illuminate\Support\Facades\Session;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Support\ListOf;

trait ColorizeTrAttribute
{

    protected function topButtons(): ListOf
    {
        return $this->topButtons()
            ->add(
                ColorizeButton::make(__('moonshine-table-colorize::ui.buttons.colorize.label'))
                    ->for($this)
            );
    }
    private function getColorizeAttribute(): string
    {
        return $this->colorizeStyleAttribute ?? config('moonshine-table-colorize.attribute', 'background-color');
    }

    private function getColorizeCursorPointer(): bool
    {
        return $this->colorizeCursorPointer ?? config('moonshine-table-colorize.cursor.pointer', true);
    }
    private function getSoftDeleteEnable(): bool
    {
        return $this->colorizeSoftDeleteEnable ?? config('moonshine-table-colorize.soft_delete.enable', true);
    }

    private function getSoftDeleteColor(): string
    {
        return $this->colorizeSoftDeleteColor ?? config('moonshine-table-colorize.soft_delete.color', '#8d514a55');
    }

    private function getColorizeCursorClass(): string
    {
        return $this->getColorizeCursorPointer() ? '; cursor: pointer;' : '';
    }
    private function getColorizePrefix(): string
    {
        return config('colorize.session.prefix', 'colorize_sets');
    }
    protected function trAttributes(): ?Closure
    {
        $colorizeSets = Session::get($this->getColorizePrefix().'.'.$this->getUriKey().'.'.$this->getListComponentName(), []);
        $colorizeCursorClass = $this->getColorizeCursorClass();
        $colorizeStyleAttribute = $this->getColorizeAttribute();
        return static function (
            ?DataWrapperContract $data,
            int $row
        ) use (
            $colorizeSets,
            $colorizeCursorClass,
            $colorizeStyleAttribute
        ): array
        {
            $style = '';
            if($colorizeSets && is_countable($colorizeSets)) {
                foreach ($colorizeSets as $set) {
                    $valueSource = $data?->getOriginal()?->{$set['sourceColumn']} ?? '';
                    $valueTarget = null;
                    switch ($set['target']['type']) {
                        case TypeFieldColorize::VALUE->value :
                            $valueTarget = $set['target']['value'] ?? '';
                            break;
                        case TypeFieldColorize::BOOL->value :
                            $valueTarget = $set['target']['bool_value'] ?? false;
                            break;
                        case TypeFieldColorize::TARGET->value :
                            $valueTarget = $data?->getOriginal()?->{$set['target']['value']} ?? 'id';
                            break;
                    }
                }
                $operator = $set['operator'];
                if ($operator == '=') $operator = '==';
                if(eval( 'return "' . $valueSource . '" ' . $operator . ' "' . $valueTarget . '";') && $valueSource !== ''){
                    $style .= $colorizeStyleAttribute . ': '. $set['color'];
                }
            }
            if( !is_null($data?->getOriginal()->deleted_at) && $this->getSoftDeleteEnable()) {
                return [
                    'style' => $colorizeStyleAttribute . ': '. $this->getSoftDeleteColor() .';' . $colorizeCursorClass,
                ];
            }
            return [
                'style'  => $style . $colorizeCursorClass,
            ];
        };
    }
}
