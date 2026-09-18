<?php

namespace Daun\StatamicIconButtons\Fieldtypes;

use Daun\StatamicIconButtons\Fieldtypes\Concerns\HasIconConfigFields;
use Daun\StatamicIconButtons\Fieldtypes\Concerns\ModifiesConfigFields;
use Statamic\Fieldtypes\Checkboxes;

class IconToggles extends Checkboxes
{
    use HasIconConfigFields;
    use ModifiesConfigFields;

    protected static $handle = 'icon_toggles';

    protected static $title = 'Icon Toggles';

    protected $icon = 'fieldtype-checkboxes';

    protected $selectableInForms = false;

    protected function configFieldItems(): array
    {
        // The core checkbox appearance (default/switch/button) doesn't apply to icon toggles
        $config = $this->removeConfigFields(parent::configFieldItems(), 'appearance');

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
        ];

        return $this->appendAppearanceConfigFields($config, [
            'size' => $this->buttonSizeConfigField(),
        ]);
    }
}
