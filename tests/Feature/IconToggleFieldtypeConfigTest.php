<?php

use Daun\StatamicIconToggle\Fieldtypes\IconToggle;
use Facades\Statamic\Fields\FieldtypeRepository;
use Illuminate\Validation\ValidationException;

function iconToggleConfigFields(array $values)
{
    $instance = new IconToggle();
    $fieldtype = FieldtypeRepository::find($instance->handle()) ?? $instance;

    return $fieldtype
        ->configBlueprint()
        ->fields()
        ->addValues($values);
}

test('throws a validation error when icon is missing from option', function () {
    $fields = iconToggleConfigFields([
        'inline_label' => 'Testing',
    ]);

    expect(fn () => $fields->validate())
        ->toThrow(ValidationException::class, 'The Icon field is required.');
});

test('does not throw a validation error when all options have icons', function () {
    $values = [
        'inline_label' => 'Testing',
        'button_icon' => 'check',
    ];

    $fields = iconToggleConfigFields($values);

    expect($fields->validate())->toEqual($values);
});
