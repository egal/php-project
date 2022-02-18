<?php

$colors = [
    'primary' => '#006c67', 'secondary' => '#08e8de',
    'warning' => '#e8c308', 'info' => '#305ff5', 'error' => '#e80831', 'success' => '#48da00',
    'light' => '#ffffff', 'dark' => '#000000', 'gray100' => '#7f7f7f',
    'gray200' => '#7f7f7f', 'gray300' => '#7f7f7f', 'gray400' => '#7f7f7f', 'gray500' => '#7f7f7f',
    'gray600' => '#7f7f7f', 'gray700' => '#7f7f7f', 'gray800' => '#7f7f7f', 'gray900' => '#7f7f7f'
];

$font = 'Open Sans';

return [

    'app' => [
        'mods' => ['colors' => $colors, 'font' => $font],
        'content' => [
            'layout' => [
                'wtype' => 'default_layout',
                'mods' => ['visible' => true],
                'content' => [
                    'header' => [
                        'mods' => ['visible' => true],
                        'content' => [],
                    ],
                    'menu' => [
                        'mods' => ['visible' => true],
                        'content' => [
                            'logo' => ['type' => 'asset', 'path' => 'logo.svg'],
                            'compact_logo' => ['type' => 'asset', 'path' => 'logo.svg'],
                            'links' => [
                                ['type' => 'link', 'label' => 'Profile', 'urn' => '/profile', 'page' => 'current_user_profile'],
                                ['type' => 'link', 'label' => 'Foo', 'urn' => '/foo', 'page' => 'foo'],
                                ['type' => 'link', 'label' => 'Bar', 'urn' => '/bar', 'page' => 'bar'],
                                ['type' => 'link', 'label' => 'Custom', 'urn' => '/custom', 'page' => 'custom'],
                                ['type' => 'nested', 'label' => 'Nested', 'links' => [
                                    ['type' => 'link', 'label' => 'Foo', 'urn' => '/foo', 'page' => 'foo'],
                                    ['type' => 'link', 'label' => 'Bar', 'urn' => '/bar', 'page' => 'bar'],
                                ]],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],

    'pages' => [
        'current_user_profile' => [
            'mods' => [
                'grid' => [
                    'columns_count' => 3,
                    'rows_count' => 3,
                    'gap' => 'medium',
                ],
            ],
            'content' => [
                [
                    'widget' => 'current_user_profile',
                    'mods' => [
                        'grid_placing' => [
                            'horizontal' => '1/2',
                            'vertical' => '1/3',
                        ],
                    ],
                ],
            ],
        ]
    ],

    'widgets' => [
        'current_user_profile' => [
            'wtype' => 'user_profile',
            'mods' => ['visible' => true],
            'content' => [
                'full_name' => [
                    'type' => 'input',
                    'content' => [
                        'type' => 'text',
                        'placeholder' => '',
                        'label' => '',
                        'error' => '',
                        'showSuccess' => false,
                        'showFilled' => true,
                        'model_value' => 'Профиль: ${requests.user.response.body.second_name} ${requests.user.response.body.first_name}',
                        'disabled' => false,
                        'validators' => [],
                        'helperText' => null,
                        'iconLeft' => null,
                        'iconRight' => null,
                        'size' => 'md',
                        'showError' => true,
                        'required' => false,
                        'showArrows' => true,
                        'min' => null,
                        'max' => null,
                        'inputMaxLength' => null,
                        'readonly' => false,
                        'clearable' => true,
                    ],
                ],
            ],
            'requests' => [
                'user' => [
                    'service_name' => 'main',
                    'resource_name' => 'users',
                    'endpoint' => 'show',
                    'params' => [
                        'key' => '${token.payload.sub}',
                    ],
                ],
            ],
        ],
    ],

];
