<template>
    <icon-fieldtype
        :key="set"
        :handle="handle"
        :config="iconConfig"
        :meta="iconMeta"
        :value="value"
        :read-only="isReadOnly"
        :field-path-prefix="fieldPathPrefix"
        @update:value="update"
    />
</template>

<script>
import { FieldtypeMixin as Fieldtype } from '@statamic/cms';

export default {
    mixins: [Fieldtype],

    computed: {
        setField() {
            return this.config.set_field || 'set';
        },

        set() {
            return this.config.set || this.siblingValue(this.setField) || 'default';
        },

        iconConfig() {
            return {
                ...this.config,
                type: 'icon',
                set: this.set,
                mode: this.config.mode || 'compact',
            };
        },

        iconMeta() {
            return { url: this.meta?.url ?? cp_url('fieldtypes/icons') };
        },
    },

    methods: {
        siblingValue(handle) {
            const values = this.publishContainer?.values ?? {};
            const keys = (this.fieldPathPrefix || this.handle).split('.').slice(0, -1);

            do {
                const value = data_get(values, [...keys, handle]);
                if (value !== null && value !== undefined) return value;
            } while (keys.pop());
        },
    },
};
</script>
