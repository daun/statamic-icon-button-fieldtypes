<?php

namespace Daun\StatamicIconButtons;

use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $vite = [
        'input' => [
            'resources/js/addon.js',
            // 'resources/css/addon.css',
        ],
        'publicDirectory' => 'resources/dist',
    ];
}
