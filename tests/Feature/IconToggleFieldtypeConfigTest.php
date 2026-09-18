<?php

use Daun\StatamicIconButtons\Fieldtypes\IconToggle;
use Facades\Statamic\Fields\FieldtypeRepository;
use Illuminate\Validation\ValidationException;
use Statamic\Fields\Field;

function iconToggleFieldtype(): IconToggle
{
    $instance = new IconToggle;

    return FieldtypeRepository::find($instance->handle()) ?? $instance;
}

function iconToggleConfigFields(array $values)
{
    return iconToggleFieldtype()
        ->configBlueprint()
        ->fields()
        ->addValues($values);
}

function iconToggleField(array $config): Field
{
    return new Field('featured', ['type' => 'icon_toggle', ...$config]);
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
        'icon' => 'check',
    ];

    $fields = iconToggleConfigFields($values);

    expect($fields->validate())->toEqual($values);
});

test('reads the icon config of a current blueprint', function () {
    $fieldtype = iconToggleField([
        'icon' => 'star',
        'icon_when_true' => 'star-filled',
    ])->fieldtype();

    expect($fieldtype->config('icon'))->toBe('star');
    expect($fieldtype->config('icon_when_true'))->toBe('star-filled');
});

test('reads the legacy button_icon config of an existing blueprint', function () {
    $fieldtype = iconToggleField([
        'button_icon' => 'star',
        'button_icon_when_true' => 'star-filled',
    ])->fieldtype();

    expect($fieldtype->config('icon'))->toBe('star');
    expect($fieldtype->config('icon_when_true'))->toBe('star-filled');
    expect($fieldtype->config('button_icon'))->toBeNull();
    expect($fieldtype->config('button_icon_when_true'))->toBeNull();
});

test('prefers the legacy icon config over a stale one injected by statamic', function () {
    $fieldtype = iconToggleField([
        'icon' => 'fieldtype-toggle',
        'button_icon' => 'star',
    ])->fieldtype();

    expect($fieldtype->config('icon'))->toBe('star');
});

test('discards a stale icon config when the legacy key is empty', function () {
    $fieldtype = iconToggleField([
        'icon' => 'fieldtype-toggle',
        'button_icon' => '',
    ])->fieldtype();

    expect($fieldtype->config('icon'))->toBeNull();
});

test('does not mutate the field it was given', function () {
    $field = iconToggleField(['button_icon' => 'star']);

    $field->fieldtype();

    expect($field->config())->toHaveKey('button_icon');
    expect($field->config())->not->toHaveKey('icon');
});

test('migrates legacy config keys when editing field settings', function () {
    $values = iconToggleFieldtype()->migrateConfig([
        'button_icon' => 'star',
        'button_icon_when_true' => 'star-filled',
    ]);

    expect($values)->toEqual([
        'icon' => 'star',
        'icon_when_true' => 'star-filled',
    ]);
});

test('drops a stale icon config when editing field settings', function () {
    $values = iconToggleFieldtype()->migrateConfig([
        'icon' => 'fieldtype-toggle',
        'button_icon' => 'star',
        'size' => 'sm',
    ]);

    expect($values)->toEqual([
        'icon' => 'star',
        'size' => 'sm',
    ]);
});

test('leaves config without legacy keys untouched', function () {
    $values = ['icon' => 'star', 'size' => 'sm'];

    expect(iconToggleFieldtype()->migrateConfig($values))->toEqual($values);
});
