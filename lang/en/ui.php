<?php

return [
    'buttons' => [
        'colorize' => [
            'label' => 'Colorize',
        ],
    ],
    'window' => [
        'title' => 'Custom colorize rows this Table.',
        'submit' => 'Apply',
    ],
    'fields' => [
        'target' => [
            'label' => 'Condition'
        ],
        'source_column' => [
            'label' => 'Source column'
        ],
        'operator' => [
            'label' => 'Operator',
            'options' => [
                '=' => 'Equals',
                '!=' => 'Not Equals',
                '>' => 'More',
                '>=' => 'Greater then or equal to',
                '<' => 'Less',
                '<=' => 'Less then or equal to',
            ]
        ],
        'column' => [
            'label' => 'Target column'
        ],
        'value' => [
            'label' => 'Value'
        ],
        'color' => [
            'label' => 'Color'
        ],
    ]
];
