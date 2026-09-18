<?php

namespace Daun\StatamicIconButtons\Fieldtypes\Concerns;

trait ModifiesConfigFields
{
    /**
     * Append fields to the parent's `Appearance` config section, creating it
     * before `Data & Format` if the parent fieldtype doesn't have one.
     */
    protected function appendAppearanceConfigFields(array $config, array $fields): array
    {
        if (($index = $this->findConfigSection($config, __('Appearance'))) !== null) {
            $config[$index]['fields'] = [...$config[$index]['fields'], ...$fields];

            return $config;
        }

        $section = ['display' => __('Appearance'), 'fields' => $fields];
        $before = $this->findConfigSection($config, __('Data & Format')) ?? count($config);

        array_splice($config, $before, 0, [$section]);

        return $config;
    }

    protected function prependConfigSection(array $config, string $display, array $fields): array
    {
        if (($index = $this->findConfigSection($config, $display)) !== null) {
            $config[$index]['fields'] = [...$fields, ...$config[$index]['fields']];

            return $config;
        }

        return [['display' => $display, 'fields' => $fields], ...$config];
    }

    /**
     * Remove config fields inherited from the parent fieldtype that don't apply here.
     */
    protected function removeConfigFields(array $config, string ...$handles): array
    {
        foreach ($config as $index => $section) {
            $config[$index]['fields'] = array_diff_key($section['fields'] ?? [], array_flip($handles));
        }

        return $config;
    }

    protected function findConfigSection(array $config, string $display): ?int
    {
        foreach ($config as $index => $section) {
            if (($section['display'] ?? null) === $display) {
                return $index;
            }
        }

        return null;
    }
}
