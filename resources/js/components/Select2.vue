<template>
    <select>
        <slot></slot>
    </select>
</template>

<script>
import $ from 'jquery';
import 'select2';

export default {
    name: "Select2",
    props: {
        options: {
            type: Array,
            default: () => [],
        },
        value: {
            type: [String, Number, Array],
            default: null,
        },
    },
    mounted() {
        // Initialize Select2
        const vm = this;
        $(this.$el)
            .select2({ data: this.options })
            .val(this.value)
            .trigger("change")
            .on("change", function () {
                vm.$emit("update:value", $(this).val());
            });
    },
    watch: {
        // Watch for changes in value
        value(newValue) {
            $(this.$el).val(newValue).trigger("change");
        },
        // Watch for changes in options
        options(newOptions) {
            $(this.$el).empty().select2({ data: newOptions });
        }
    },
    beforeDestroy() {
        $(this.$el).off().select2("destroy");
    },
};
</script>
