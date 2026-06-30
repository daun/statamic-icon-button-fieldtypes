<template>
    <ui-button-group overflow="stack">
        <ui-button
            v-for="(option, $index) in options"
            ref="button"
            :disabled="config.disabled"
            :key="$index"
            :name="name"
            :read-only="isReadOnly"
            :icon-only="true"
            :value="option.value"
            :variant="value == option.value ? 'pressed' : 'default'"
            :aria-label="option.label || option.value"
            :size="config.size || 'base'"
            v-tooltip="option.label || option.value"
            @click="updateSelectedOption(option.value)"
        >
            <ui-icon :name="option.icon" :set="config.set ?? 'default'" />
        </ui-button>
    </ui-button-group>
</template>

<script>
import { FieldtypeMixin as Fieldtype } from '@statamic/cms';

export default {
    mixins: [Fieldtype],

    computed: {
        options() {
            return this.normalizeInputOptions(this.config.options);
        },

        replicatorPreview() {
            if (!this.showFieldPreviews || !this.value) return;

            var option = this.options.find((o) => o.value === this.value);
            return option ? option.label : this.value;
        },
    },

    methods: {
        updateSelectedOption(newValue) {
            this.update(this.value == newValue && this.config.clearable ? null : newValue);
        },

        focus() {
            this.$refs.button[0].focus();
        },

        normalizeInputOptions(options) {
            return options.map((option) => {
                const { key, value, icon } = option;

                return {
                    value: key,
                    label: `${__(value) || value || key}`,
                    icon: icon,
                };
            });
        },
    },
};
</script>
