<?php

return [
    'cursor' => [
        'pointer' => true
    ],
    
    'soft_delete' => [
        'enable' => true,
        'color' => '#8d514a55'
    ],
    'middleware' => [
        'web',
        'auth'
    ],

    'attribute' => 'background-color',

    'prefix' => 'colorize_sets'
];
