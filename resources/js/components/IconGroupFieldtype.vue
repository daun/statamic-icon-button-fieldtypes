<template>
    <ButtonGroup ref="buttonGroup">
        <Button
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
            <Icon :name="option.icon" :set="config.set ?? 'default'" />
        </Button>
    </ButtonGroup>
</template>

<script>
import { FieldtypeMixin as Fieldtype } from '@statamic/cms';
import { Button, ButtonGroup, Icon } from '@statamic/cms/ui';

export default {
    mixins: [Fieldtype],
    components: {
        Button,
        ButtonGroup,
        Icon,
    },

    data() {
        return {
            resizeObserver: null,
        };
    },

    mounted() {
        this.setupResizeObserver();
    },

    beforeUnmount() {
        this.resizeObserver.disconnect();
    },

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

        setupResizeObserver() {
            this.resizeObserver = new ResizeObserver(() => {
                this.handleWrappingOfNode(this.$refs.buttonGroup.$el);
            });
            this.resizeObserver.observe(this.$refs.buttonGroup.$el);
        },

        handleWrappingOfNode(node) {
            const lastEl = node.lastChild;

            if (!lastEl) return;

            node.classList.remove('btn-vertical');

            if (lastEl.offsetTop > node.clientTop) {
                node.classList.add('btn-vertical');
            }
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
