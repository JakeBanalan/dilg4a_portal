
<style>
.input-group-prepend{
  height: 40px !important;
}

</style>
<template>
  <div class="form-group">
    <label>{{ label }}</label>
    <div class="input-group">
      <div class="input-group-prepend">
        <span class="input-group-text">
          <!-- Add your icon here -->
          <font-awesome-icon :icon="[ 'fas', iconValue ]" />
        </span>
      </div>
      <input v-bind="$attrs" v-model="internalValue" class="form-control" :placeholder="placeholder" :type="type" :readonly="readonly" />
    </div>
  </div>
</template>

<script>
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faBars, faBarsProgress, faBuilding, faCalendar, faCopyright, faEnvelopeOpenText, faHashtag, faServer, faUser } from '@fortawesome/free-solid-svg-icons';

library.add(faCalendar,faUser,faBarsProgress,faEnvelopeOpenText,faServer,faCopyright,faHashtag,faBuilding,faBars);

export default {
  components: {
    FontAwesomeIcon
  },
  name: 'TextInput',
  props: {
    label: {
      type: String,
      default: ''
    },
    value: {
      type: [String, Number, Date],
      default: ''
    },
    placeholder: {
      type: String,
      default: ''
    },
    type: {
      type: String,
      default: 'text'
    },
    readonly: {
      type: Boolean,
      default: false
    },
    iconValue: { // Adding prop for the icon value
      type: String,
      default: '' // Default icon value (can be overridden)
    }
  },
  data() {
    return {
      internalValue: this.value
    }
  },
  emits: ['update:modelValue'],
  watch: {
    internalValue(newValue) {
      this.$emit('update:modelValue', newValue); // Emit input event when value changes
    },
    value(newValue) {
      this.internalValue = newValue; // Update internalValue if external value changes
    }
  }
};
</script>

<style scoped>
/* Add any scoped styles here if needed */
</style>
