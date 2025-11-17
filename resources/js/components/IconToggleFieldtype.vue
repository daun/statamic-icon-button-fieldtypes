<template>
    <div class="flex items-center gap-2">
        <Button
            :disabled="config.disabled"
            :id="fieldId"
            :name="name"
            :value="value"
            :read-only="isReadOnly"
            :icon-only="true"
            :variant="value ? 'pressed' : 'default'"
            :aria-label="tooltip"
            :size="config.size || 'base'"
            v-tooltip="tooltip"
            @click="toggleValue"
        >
            <Icon :name="buttonIcon" :set="config.set ?? 'default'" />
        </Button>
        <Heading v-if="inlineLabel" v-html="$markdown(__(inlineLabel), { openLinksInNewTabs: true })" />
    </div>
</template>

<script>
import { FieldtypeMixin as Fieldtype } from '@statamic/cms';
import { Button, Heading, Icon } from '@statamic/cms/ui';

export default {
    mixins: [Fieldtype],

    components: {
        Button,
        Heading,
        Icon,
    },

    computed: {
        inlineLabel() {
            return this.value
                ? this.config.inline_label_when_true || this.config.inline_label
                : this.config.inline_label;
        },

        tooltip() {
            return this.value
                ? this.config.tooltip_when_true || this.config.tooltip
                : this.config.tooltip;
        },

        buttonIcon() {
            return this.value
                ? this.config.button_icon_when_true || this.config.button_icon
                : this.config.button_icon;
        },

        replicatorPreview() {
            if (!this.showFieldPreviews) return;

            return (this.value ? '✓' : '✗') + ' ' + __(this.config.display);
        },
    },

    methods: {
        toggleValue() {
            this.update(!this.value);
        },
    },
};
</script>
