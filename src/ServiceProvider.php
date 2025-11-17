<?php

namespace Daun\StatamicIconGroup;

use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $fieldtypes = [
        Fieldtypes\IconGroup::class,
    ];

    protected $vite = [
        'input' => [
            'resources/js/addon.js',
            // 'resources/css/addon.css',
        ],
        'publicDirectory' => 'resources/dist',
    ];
}
