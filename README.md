# Statamic Icon Button Fieldtypes

Icon-only button fieldtypes for compact toggles and switches.

![Example icon button fields](art/icon-buttons.png)

## Installation

Install the addon via Composer:

```bash
composer require daun/statamic-icon-button-fieldtypes
```

## Fieldtypes

The addon ships with three fieldtypes, each extending a native Statamic fieldtype:

- Single-choice **[Icon Group](#icon-group)** extends the native Button Group
- Multi-Choice **[Icon Toggles](#icon-toggles)** extends the Checkboxes fieldtype
- Boolean **[Icon Toggle](#icon-toggle)** extends the Toggle fieldtype

### Icon Group

The **Icon Group** fieldtype extends the native [Button Group](https://statamic.dev/fieldtypes/button_group)
fieldtype and allows selecting a single option from a predefined set of options.

![Example icon group fields](art/icon-group.png)

```diff
align:
  display: Align
- type: button_group
+ type: icon_group
  options:
    -
      value: Left
      key: left
+     icon: align-start-vertical
    -
      value: Right
      key: right
+     icon: align-end-vertical
```

## Icon Toggles

The **Icon Toggles** fieldtype extends the native [Checkboxes](https://statamic.dev/fieldtypes/checkboxes)
fieldtype and allows selecting one or more options from a predefined set of options.

![Example icon toggles field](art/icon-toggles.png)

```diff
playback:
  display: Playback options
- type: checkboxes
+ type: icon_toggles
  options:
    -
      value: sound
      key: sound
+     icon: volume
    -
      value: Loop
      key: loop
+     icon: repeat
    -
      value: Captions
      key: captions
+     icon: captions
```

## Icon Toggle

The **Icon Toggle** fieldtype extends the native [Toggle](https://statamic.dev/fieldtypes/toggle)
fieldtype and allows switching a single value on or off.

![Example icon toggles field](art/icon-toggle.png)

```diff
featured:
  display: Featured
- type: toggle
+ type: icon_toggle
+ button_icon: star
```

Note that the option here is called `button_icon` because `icon` key is a reserved key by Statamic.

## Custom Icon Sets

Icons are pulled from the built-in control panel icon set. To use icons from a different set, change the `set` option of each field to the desired set.

### Example: Lucide

The example steps below will install and use icons from the [Lucide](https://lucide.dev/icons/) icon
set, used in the examples above.

Install icon set:

```sh
npm install lucide-static
```

Register icon set in control panel:

```js
// resource/js/cp.js

import { registerIconSet } from '@statamic/cms/ui';

Statamic.booting(() => {
    registerIconSet('lucide', import.meta.glob(
        '../../node_modules/lucide-static/icons/*.svg',
        { query: '?raw', import: 'default' }
    ));
});
```

Switch field to use icon set:

```diff
visibility:
  type: icon_group
  display: Visibility
+ set: lucide
  options:
    -
      value: Public
      key: public
      icon: eye
    -
      value: Private
      key: private
      icon: eye-off
```

## License

[MIT](https://opensource.org/licenses/MIT)
