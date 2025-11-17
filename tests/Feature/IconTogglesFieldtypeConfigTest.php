<?php

use Daun\StatamicIconToggle\Fieldtypes\IconToggles;
use Facades\Statamic\Fields\FieldtypeRepository;
use Illuminate\Validation\ValidationException;

function iconTogglesConfigFields(array $values)
{
    $instance = new IconToggles();
    $fieldtype = FieldtypeRepository::find($instance->handle()) ?? $instance;

    return $fieldtype
        ->configBlueprint()
        ->fields()
        ->addValues($values);
}

test('throws a validation error when icon is missing from option', function () {
    $fields = iconTogglesConfigFields([
        'options' => [
            [
                'key' => 'one',
                'value' => 'One',
                'icon' => 'icon-one',
            ],
            [
                'key' => 'two',
                'value' => 'Two',
                // 'icon' => 'icon-two', // Missing icon
            ],
        ],
    ]);

    expect(fn () => $fields->validate())
        ->toThrow(ValidationException::class, 'The Icon field is required.');
});

test('does not throw a validation error when all options have icons', function () {
    $values = [
        'options' => [
            [
                'key' => 'one',
                'value' => 'One',
                'icon' => 'icon-one',
            ],
            [
                'key' => 'two',
                'value' => 'Two',
                'icon' => 'icon-two',
            ],
        ],
    ];

    $fields = iconTogglesConfigFields($values);

    expect($fields->validate())->toEqual($values);
});

test('does not throw a validation error when label is missing from option', function () {
    $fields = iconTogglesConfigFields([
        'options' => [
            [
                'key' => 'one',
                'value' => 'One',
                'icon' => 'icon-one',
            ],
            [
                'key' => 'two',
                // 'value' => 'Two',
                'icon' => 'icon-two',
            ],
        ],
    ]);

    expect(fn () => $fields->validate())->not->toThrow(ValidationException::class);
});
