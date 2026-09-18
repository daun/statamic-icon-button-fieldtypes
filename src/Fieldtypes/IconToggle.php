<?php

namespace Daun\StatamicIconButtons\Fieldtypes;

use Daun\StatamicIconButtons\Fieldtypes\Concerns\MigratesLegacyConfig;
use Statamic\Fieldtypes\Toggle;

class IconToggle extends Toggle
{
    use MigratesLegacyConfig;

    protected static $handle = 'icon_toggle';

    protected static $title = 'Icon Toggle';

    protected $icon = 'fieldtype-toggle';

    protected $selectableInForms = false;

    protected function legacyConfigKeys(): array
    {
        return [
            'button_icon' => 'icon',
            'button_icon_when_true' => 'icon_when_true',
        ];
    }

    protected function configFieldItems(): array
    {
        $config = parent::configFieldItems();

        $config[0]['fields'] = [
            'set' => [
                'display' => __('Icon Set'),
                'instructions' => __('statamic::fieldtypes.icon.config.set'),
                'type' => 'text',
                'placeholder' => 'default',
            ],
            'icon' => [
                'display' => __('Icon'),
                'type' => 'text',
                'validate' => 'required',
            ],
            'icon_when_true' => [
                'display' => __('Icon when True'),
                'type' => 'text',
            ],
            ...$config[0]['fields'], // Inline label config
            'tooltip' => [
                'display' => __('Tooltip'),
                'type' => 'text',
            ],
            'tooltip_when_true' => [
                'display' => __('Tooltip when True'),
                'type' => 'text',
                'default' => '',
                'width' => '50',
            ],
            'size' => [
                'display' => __('Button Size'),
                'type' => 'button_group',
                'options' => [
                    'sm' => __('Small'),
                    'base' => __('Medium'),
                ],
                'default' => 'base',
            ],
        ];

        return $config;
    }
}
