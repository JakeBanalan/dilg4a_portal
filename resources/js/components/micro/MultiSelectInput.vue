<template>
    <div class="form-group">
      <label>{{ label }}</label>
      <select v-model="selectedItems" multiple class="form-control select2 selectpicker" :style="{ width: '100%' }">
        <option v-for="option in filteredOptions" :value="option.value" :key="option.value">{{ option.label }}</option>
      </select>
    </div>
  </template>

  <script>
  import 'select2/dist/css/select2.min.css'; // Import Select2 CSS
  import $ from 'jquery'; // Import jQuery
  import 'select2'; // Import Select2 JavaScript

  export default {
    name: 'MultiSelectInput',
    props: {
      label: {
        type: String,
        default: ''
      },
      options: {
        type: Array,
        default: () => []
      },
      value: {
        type: Array, // Ensure value prop is an array
        default: () => [] // Default value as an empty array
      }
    },
    data() {
      return {
        selectedItems: this.value // Initialize selectedItems with the value prop
      };
    },
    mounted() {
      const vm = this;
      $(this.$el).find('.select2').select2().on('change', function() {
        vm.selectedItems = $(this).val();
      });
    },
    computed: {
      filteredOptions() {
        return this.options;
      }
    },
    watch: {
      value(newValue) {
        // Update selectedItems when the value prop changes from outside
        this.selectedItems = newValue;
      },
      selectedItems(newSelectedItems) {
        // Emit an input event when selectedItems change
        this.$emit('input', newSelectedItems);
      }
    }
  };
  </script>
