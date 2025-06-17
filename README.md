## Плагин пользовательской покраски строк индексной таблицы в  [MoonShine Laravel admin panel](https://moonshine-laravel.com) v3

Этот модуль позволяет добавить форму для раскраски строк в индекстной таблице ресурса по пользовательскому условию.

<picture>
  <source media="(prefers-color-scheme: dark)" srcset="./art/1.png">
  <source media="(prefers-color-scheme: light)" srcset="./art/1.png">
  <img alt="cover" src="./art/1.png">
</picture>

## Установка
```shell
composer require ermakk/ms-table-colorize
```


## Поддерживает

| MoonShine | MoonShine Table Colorize | Currently supported |
|:---------:|:------------------------:|:-------------------:|
|  < v3.0   |           ...            |         no          |
| \>= v3.0  |         >= v1.0          |         yes         |


## Использование

Для добавления функционала, достаточно подключить трейт к ресурсу
```php
//...Resource.php

//class YourModelResource extends ModelResource
use Ermakk\MoonshineTableColorize\Traits\ColorizeTrAtribute;

// ...

// Если у вас уже есть кнопки и требуется их сохранить
protected function topButtons(): ListOf
{
    return parent::topButtons()
        ->add(
            ColorizeButton::make()->for($this)
        )
        ->// ... ваши кнопки
        ;
}

```

По умолчанию модуль выделяет удаленные строки, 

чтобы включить или отключить это выделение переопределите параметр `colorizeSoftDeleteEnable`

```php
//...Resource.php

// ...
protected bool $colorizeSoftDeleteEnable = true; // true - включено, false - выключено
// ... 
```

Так же по умолчанию модуль добавляет стиль для курсора `cursor: pointer` строкам таблицы,

чтобы включить или отключить это выделение переопределите параметр `colorizeCursorPointer`

```php
//...Resource.php

// ...
protected bool $colorizeCursorPointer = true; // true - включено, false - выключено
// ... 
```

Вы можете изменить css аттрибут, которому будет задаваться цвет,

для этого задайте это значение в строковый параметр `colorizeStyleAttribute`

```php
//...Resource.php

// ...
protected string $colorizeStyleAttribute = 'background-color';
// ... 
```



## Изменение конфига

Помимо настроек из ресурса можно имезнить конфигурацию, для изменения конфигурации по-умолчанию:

```shell
php artisan vendor:publish --tag="moonshine-table-colorize"
```