<?php

namespace Daun\StatamicIconButtons\Fieldtypes;

use Daun\StatamicIconButtons\Fieldtypes\Concerns\HasIconConfigFields;
use Daun\StatamicIconButtons\Fieldtypes\Concerns\MigratesLegacyConfig;
use Statamic\Fieldtypes\Toggle;

class IconToggle extends Toggle
{
    use HasIconConfigFields;
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
            'set' => $this->iconSetConfigField(),
            'icon' => $this->iconConfigField([
                'instructions' => __('Set an icon to be shown as the toggle.'),
                'validate' => 'required',
            ]),
            'icon_when_true' => $this->iconConfigField([
                'display' => __('Icon when True'),
                'instructions' => __('Set an icon to be shown when the toggle\'s value is true.'),
            ]),
            ...$config[0]['fields'], // Inline label config
            'tooltip' => [
                'display' => __('Tooltip'),
                'instructions' => __('Set a tooltip to be shown when the toggle is focused or hovered.'),
                'type' => 'text',
            ],
            'tooltip_when_true' => [
                'display' => __('Tooltip when True'),
                'instructions' => __('Set a tooltip to be shown when the toggle\'s value is true.'),
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
