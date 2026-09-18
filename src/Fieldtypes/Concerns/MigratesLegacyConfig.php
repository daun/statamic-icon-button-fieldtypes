<?php

namespace Daun\StatamicIconButtons\Fieldtypes\Concerns;

use Statamic\Fields\Field;

trait MigratesLegacyConfig
{
    /** @return array<string, string> Legacy config key => current config key */
    abstract protected function legacyConfigKeys(): array;

    public function setField(Field $field)
    {
        parent::setField($field);

        $this->field->setConfig($this->migrateConfig($this->field->config()));

        return $this;
    }

    public function migrateConfig(array $values): array
    {
        $values = parent::migrateConfig($values);

        foreach ($this->legacyConfigKeys() as $legacy => $current) {
            if (! array_key_exists($legacy, $values)) {
                continue;
            }

            $value = $values[$legacy];

            unset($values[$legacy], $values[$current]);

            if (filled($value)) {
                $values[$current] = $value;
            }
        }

        return $values;
    }
}
