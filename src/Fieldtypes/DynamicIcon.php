<?php

namespace Daun\StatamicIconButtons\Fieldtypes;

use Statamic\Fieldtypes\Icon;

/**
 * A thin proxy around Statamic's `icon` fieldtype for use *inside* field configs.
 *
 * The core fieldtype resolves its icon set from its own static config, which
 * doesn't work when the set is picked in a sibling config field. This one
 * resolves the set client-side from the surrounding publish container.
 */
class DynamicIcon extends Icon
{
    protected static $handle = 'dynamic_icon';

    protected static $title = 'Dynamic Icon';

    protected $selectableInForms = false;

    /**
     * @param  string  $setField  Handle of the sibling config field holding the icon set
     */
    public static function configField(string $setField = 'set', array $overrides = []): array
    {
        return [
            'display' => __('Icon'),
            'type' => static::handle(),
            'set_field' => $setField,
            'mode' => 'compact',
            ...$overrides,
        ];
    }

    protected function configFieldItems(): array
    {
        return [
            'set_field' => [
                'display' => __('Icon Set Field'),
                'instructions' => __('Handle of the sibling field holding the icon set.'),
                'type' => 'text',
                'default' => 'set',
            ],
        ];
    }
}
