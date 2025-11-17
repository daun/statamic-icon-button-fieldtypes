<?php

namespace Daun\StatamicIconButtons\Fieldtypes;

use Statamic\Fieldtypes\Toggle;

class IconToggle extends Toggle
{
    protected static $handle = 'icon_toggle';

    protected static $title = 'Icon Toggle';

    protected $icon = 'fieldtype-toggle';

    protected $selectableInForms = false;

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
            'button_icon' => [
                'display' => __('Icon'),
                'type' => 'text',
                'validate' => 'required',
            ],
            'button_icon_when_true' => [
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
