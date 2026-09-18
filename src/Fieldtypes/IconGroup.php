<?php

namespace Daun\StatamicIconButtons\Fieldtypes;

use Daun\StatamicIconButtons\Fieldtypes\Concerns\HasIconConfigFields;
use Statamic\Fieldtypes\ButtonGroup;

class IconGroup extends ButtonGroup
{
    use HasIconConfigFields;

    protected static $handle = 'icon_group';

    protected static $title = 'Icon Group';

    protected $icon = 'fieldtype-button_group';

    protected function configFieldItems(): array
    {
        $config = parent::configFieldItems();

        $config[0]['fields'] = [
            ...$config[0]['fields'],
            'options' => [
                'display' => __('Options'),
                'instructions' => __('statamic::fieldtypes.radio.config.options'),
                'type' => 'grid',
                'fields' => [
                    'key' => [
                        'handle' => 'key',
                        'display' => __('Value'),
                        'field' => [
                            'type' => 'text',
                            'validate' => 'required',
                        ],
                    ],
                    'value' => [
                        'handle' => 'value',
                        'display' => __('Label'),
                        'field' => [
                            'type' => 'text',
                        ],
                    ],
                    'icon' => [
                        'handle' => 'icon',
                        'display' => __('Icon'),
                        'field' => $this->iconConfigField(['validate' => 'required']),
                    ],
                ],
                'add_row' => __('Add Option'),
                'fullscreen' => false,
                'full_width_setting' => true,
            ],
            'set' => $this->iconSetConfigField(),
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
