<template>
  <button :disabled="disabled" class="btn btn-primary mr-1" style="background-color:#059886;color:#fff;" @click="onClick">
    <font-awesome-icon :icon="['fas', 'square-poll-vertical']" />
    <span style="color:#fff; margin-left:6px;">Survey Link</span>
  </button>
</template>

<script>
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

export default {
  name: 'SurveyLinkButton',
  components: { FontAwesomeIcon },
  props: {
    cssLink: { type: String, required: true },
    disabled: { type: Boolean, default: false }
  },
  methods: {
    onClick(event) {
      if (this.disabled) return;
      // Emit clicked so parent can mark survey taken before navigating
      this.$emit('clicked');
      // Open link in new tab after a tiny delay to allow parent to send API
      const url = this.cssLink;
      setTimeout(() => {
        if (url) window.open(url, '_blank');
      }, 200);
    }
  }
};
</script>
