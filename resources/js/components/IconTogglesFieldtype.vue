<template>
    <div class="flex flex-wrap gap-2">
        <Button
            v-for="(option, $index) in options"
            :disabled="config.disabled"
            :key="$index"
            :name="name"
            :read-only="isReadOnly"
            :icon-only="true"
            :value="option.value"
            :variant="hasOption(option.value) ? 'pressed' : 'default'"
            :aria-label="option.label || option.value"
            :size="config.size || 'base'"
            v-tooltip="option.label || option.value"
            @click="updateOption(option.value)"
        >
            <Icon :name="hasOption(option.value) ? (option.icon_when_true || option.icon) : option.icon" :set="config.set ?? 'default'" />
        </Button>
    </div>
</template>

<script>
import { FieldtypeMixin as Fieldtype } from '@statamic/cms';
import { Button, Icon } from '@statamic/cms/ui';

export default {
    mixins: [Fieldtype],

    components: {
        Button,
        Icon,
    },

    data() {
        return {
            values: this.value || [],
        };
    },

    computed: {
        options() {
            return this.normalizeInputOptions(this.config.options);
        },

        replicatorPreview() {
            if (!this.showFieldPreviews) return;

            return this.values
                .map((value) => {
                    const option = this.options.find((o) => o.value === value);
                    return option ? option.label : value;
                })
                .join(', ');
        },
    },

    watch: {
        values(values, oldValues) {
            values = this.sortValues(values);

            if (JSON.stringify(values) === JSON.stringify(oldValues)) return;

            this.update(values);
        },

        value(value) {
            this.values = this.sortValues(value);
        },
    },

    methods: {
        focus() {
            this.$refs.buttons.focus();
        },

        sortValues(values) {
            if (!values) return [];

            return this.options.filter((opt) => values.includes(opt.value)).map((opt) => opt.value);
        },

        normalizeInputOptions(options) {
            return options.map((option) => {
                const { key, value, icon, icon_when_true } = option;

                return {
                    value: key,
                    label: `${__(value) || value || key}`,
                    icon,
                    icon_when_true,
                };
            });
        },

        hasOption(optionValue) {
            return this.values.includes(optionValue);
        },

        updateOption(optionValue) {
            this.values = this.hasOption(optionValue)
                ? this.values.filter((val) => val !== optionValue)
                : [...this.values, optionValue];
        }
    },
};
</script>
