<?php

use Daun\StatamicIconButtons\Fieldtypes\DynamicIcon;
use Daun\StatamicIconButtons\Fieldtypes\IconGroup;
use Daun\StatamicIconButtons\Fieldtypes\IconToggle;
use Facades\Statamic\Fields\FieldtypeRepository;
use Statamic\Facades\Icon as Icons;
use Statamic\Fields\Field;

test('is registered', function () {
    expect(FieldtypeRepository::find(DynamicIcon::handle()))->toBeInstanceOf(DynamicIcon::class);
});

test('preloads the icon endpoint used by the core icon fieldtype', function () {
    $fieldtype = (new DynamicIcon)->setField(new Field('icon', ['type' => 'dynamic_icon']));

    expect($fieldtype->preload()['url'])->toEndWith('/fieldtypes/icons');
});

test('icon toggle uses the picker for its icon config fields', function () {
    $fields = (new IconToggle)->configBlueprint()->fields()->all();

    expect($fields->get('icon')->type())->toBe('dynamic_icon');
    expect($fields->get('icon')->config()['set_field'])->toBe('set');
    expect($fields->get('icon_when_true')->type())->toBe('dynamic_icon');
});

test('icon group option rows use the picker and preload its meta', function () {
    $options = (new IconGroup)->configBlueprint()->fields()->get('options');

    expect($options->config()['fields']['icon']['field']['type'])->toBe('dynamic_icon');

    // Grid preloads meta for nested fields, so the picker receives its url without an extra request
    expect($options->fieldtype()->preload()['defaults'])->toHaveKey('icon');
    expect($options->fieldtype()->preload()['new']['icon'])->toHaveKey('url');
});

test('the icon set config field stays a text field when no custom sets are registered', function () {
    $set = (new IconToggle)->configBlueprint()->fields()->get('set');

    expect($set->type())->toBe('text');
});

test('the icon set config field lists registered sets', function () {
    Icons::register('lucide', __DIR__);

    $set = (new IconToggle)->configBlueprint()->fields()->get('set');

    expect($set->type())->toBe('select');
    expect($set->config()['options'])->toBe(['default' => 'Default', 'lucide' => 'Lucide']);
});
