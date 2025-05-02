<template>
    <button class="btn btn-primary mr-1" style="background-color:#059886;color:#fff;">
      <font-awesome-icon :icon="['fas', 'square-poll-vertical']" />
      <a :href="cssLink" target="_blank" style="color:#fff"> Survey Link</a>
    </button>
  </template>

  <script>
  import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

  export default {
    name: 'SurveyLinkButton',
    components: {
      FontAwesomeIcon
    },
    props: {
      cssLink: {
        type: String,
        required: true
      }
    }
  };
  </script>
