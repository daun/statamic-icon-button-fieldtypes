<?php

namespace Daun\StatamicIconButtons\Fieldtypes\Concerns;

use Daun\StatamicIconButtons\Fieldtypes\DynamicIcon;
use Statamic\Facades\Icon as Icons;
use Statamic\Icons\IconSet;
use Statamic\Support\Str;

trait HasIconConfigFields
{
    protected function iconSetConfigField(array $overrides = []): array
    {
        $sets = $this->iconSetOptions();

        return [
            'display' => __('Icon Set'),
            'instructions' => __('statamic::fieldtypes.icon.config.set'),
            ...(count($sets) > 1
                ? ['type' => 'select', 'options' => $sets, 'default' => 'default']
                : ['type' => 'text', 'placeholder' => 'default']),
            ...$overrides,
        ];
    }

    protected function iconConfigField(array $overrides = [], string $setField = 'set'): array
    {
        return DynamicIcon::configField($setField, $overrides);
    }

    protected function iconSetOptions(): array
    {
        return Icons::sets()
            ->mapWithKeys(fn (IconSet $set) => [$set->name() => Str::headline($set->name())])
            ->prepend(__('Default'), 'default')
            ->all();
    }
}
