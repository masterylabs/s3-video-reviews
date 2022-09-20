<?php

use Masteryl\Modules\UserAuth\UserAuthMiddleware;

return [
    'route_path' => 'brand',
    'middleware' => UserAuthMiddleware::class,
    'require_addons' => [
        'developer',
    ],
    'unbranded' => [
        'app' => [
            'name',
            'description',
            'label',
        ],
    ],
    'addons_filter' => [
        'unlimited',
        // 'premium',
        'developer',
        'reseller',
        'wl',
    ],
    'fields' => [
        'primary' => [
            [
                'text' => 'Active',
                'value' => 'is_active',
                'type' => 'bool',
            ],
        ],
        'brand' => [
            [
                'text' => 'Name',
                'value' => 'name',
                'required' => true,
            ],
            [
                'text' => 'Label',
                'value' => 'label',
            ],
            [
                'text' => 'Menu Title',
                'value' => 'menu_title',
                'required' => true,
            ],
            [
                'text' => 'Unique URL Slug',
                'value' => 'slug',
                'required' => true,
            ],
            [
                'text' => 'Logo',
                'value' => 'logo',
                'component' => 'link',
            ],
            [
                'text' => 'Logo Link',
                'value' => 'logo_link',
                'component' => 'link',
            ],
        ],
        'access' => [
            [
                'text' => 'Include Addons',
                'value' => 'addons',
                'items' => 'addons',
                'type' => 'array',
            ],
            [
                'text' => 'Application Access',
                'value' => 'user_roles',
                'items' => 'roles',
                'type' => 'array',
            ],
            [
                'text' => 'Branding Access',
                'value' => 'admin_roles',
                'items' => 'roles',
                'type' => 'array',
            ],
        ],
        'colors' => [
            [
                'title' => 'Primary Color',
                'value' => 'primary_color',
                'default_value' => '#2271B1',
            ],
            [
                'title' => 'Secondary Color',
                'value' => 'secondary_color',
                'default_value' => '#232f3e',
            ],
            [
                'title' => 'Accent Color',
                'value' => 'accent_color',
                'default_value' => '#FF9800',
            ],
        ],

        'options' => [
            [
                'text' => 'Hide Plugin',
                'value' => 'hide_plugin',
                'type' => 'bool',
            ],
        ],
    ],
];
