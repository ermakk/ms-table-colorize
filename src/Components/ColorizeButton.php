<?php

namespace Ermakk\MoonshineTableColorize\Components;

use Ermakk\MoonshineTableColorize\Enums\TypeFieldColorize;
use Illuminate\Support\Facades\Session;
use MoonShine\Support\AlpineJs;
use MoonShine\Support\Enums\JsEvent;
use MoonShine\UI\Collections\Fields;
use MoonShine\UI\Components\Modal;
use MoonShine\UI\Fields\Checkbox;
use MoonShine\UI\Fields\Color;
use MoonShine\UI\Fields\Enum;
use MoonShine\UI\Fields\Field;
use MoonShine\UI\Fields\Json;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use Throwable;

final class ColorizeButton extends \MoonShine\UI\Components\ActionButton
{


    public function __construct() {
        parent::__construct(__('moonshine-table-colorize::ui.buttons.colorize.label'));
        $this->setLabel(__('moonshine-table-colorize::uie.buttons.colorize.label'));
    }
    /**
     * @throws Throwable
     */
    public function for(
        \MoonShine\Laravel\Resources\CrudResource $resource
    ): \MoonShine\Contracts\UI\ActionButtonContract
    {
        $fields = [];
        $baseFields = $resource->colorizeFields();
        $baseFields = $baseFields !== [] ? $baseFields : $resource->getIndexFields()->indexFields()->all();
        foreach ($baseFields as $itemsField){
            $fields[$itemsField->getColumn()] = $itemsField->getLabel() !== '' ? $itemsField->getLabel() : $itemsField->getColumn();
        }
        $colorizeSets = Session::get('colorize_sets.'.$resource->getUriKey().'.'.$resource->getListComponentName(), []);
        return $this
            ->name('table-colorize-button')
            ->setLabel(__('moonshine-table-colorize::ui.buttons.colorize.label'))
//            ->canSee(static fn(): bool  => $resource->isColorize ?? false)
            ->badge($colorizeSets && is_countable($colorizeSets) ? count($colorizeSets) : null)
            ->inModal(
                title: __('moonshine-table-colorize::ui.window.title'),
                content: \MoonShine\UI\Components\FormBuilder::make(route('api.rest.colorize.set'))
                    ->withoutRedirect()
                    ->name($resource->getUriKey())
                    ->submit( __('moonshine-table-colorize::ui.window.submit'))
                    ->async(events: [
                        AlpineJs::event(\MoonShine\Support\Enums\JsEvent::TABLE_UPDATED, $resource->getListComponentName()),
                        AlpineJs::event(JsEvent::FORM_RESET, $resource->getUriKey()),
                    ])
                    ->fields([
                        \MoonShine\UI\Fields\Hidden::make('resource', '_resource')->setValue($resource->getUriKey()),
                        \MoonShine\UI\Fields\Hidden::make('resource', '_listComponentName')->setValue($resource->getListComponentName()),
                        \MoonShine\UI\Fields\Json::make('', 'colorize')
                            ->fields(fn($item) => [
                                Select::make(__('moonshine-table-colorize::ui.fields.source_column.label'), 'sourceColumn')
                                    ->options($fields)
                                    ->required(),

                                // Выбор оператора
                                Select::make(__('moonshine-table-colorize::ui.fields.operator.label'), 'operator')
                                    ->options([
                                        '=' => __('moonshine-table-colorize::ui.fields.operator.options.='),
                                        '!=' => __('moonshine-table-colorize::ui.fields.operator.options.!='),
                                        '>' => __('moonshine-table-colorize::ui.fields.operator.options.>'),
                                        '>=' => __('moonshine-table-colorize::ui.fields.operator.options.>='),
                                        '<' => __('moonshine-table-colorize::ui.fields.operator.options.<'),
                                        '<=' => __('moonshine-table-colorize::ui.fields.operator.options.<='),
                                    ])
                                    ->required(),

                                Json::make(__('moonshine-table-colorize::ui.fields.target.label'), 'target')->fields([

                                    Enum::make('', 'type')
                                        ->attach(TypeFieldColorize::class)
                                        ->default(TypeFieldColorize::VALUE->value),

                                    // Выбор колонки
                                    Select::make(__('moonshine-table-colorize::ui.fields.column.label'), 'column')
                                        ->options($fields)
                                        ->showWhen('colorize.1.target.type', TypeFieldColorize::TARGET->value),
                                    // Выбор колонки
                                    Switcher::make(__('moonshine-table-colorize::ui.fields.value.label'), 'bool_value')
                                        ->showWhen('colorize.1.target.type', TypeFieldColorize::BOOL->value),

                                    Text::make(__('moonshine-table-colorize::ui.fields.value.label'), 'value')
                                        ->showWhen('colorize.1.target.type', TypeFieldColorize::VALUE->value),

                                ])
                                    ->object()
                                    ->vertical()
                                    ->reorderable(false),
                                Color::make(__('moonshine-table-colorize::ui.fields.color.label'), 'color')->default('#a6c8d3')

                            ])
                            ->setValue($colorizeSets ?? [])
                            ->removable(fn() => true)
                            ->reorderable(false)
                            ->creatable(limit: $colorizeSets && is_countable($colorizeSets) ? count($colorizeSets) + 1 : 1)

                    ]),
                name: 'colorize-button',
                builder: static fn (Modal $modal): Modal => $modal->wide()->closeOutside(false)
            )
            ->primary();
    }
}
