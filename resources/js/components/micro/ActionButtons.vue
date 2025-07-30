<template>
    <div>
      <template v-if="role === 'admin'">
        <div v-if="status === 'Received'">
          <button
            class="btn btn-icon mr-1"
            style="background-color:#059886;color:#fff;"
            @click="$emit('view', id)"
            aria-label="View Details"
            title="Show"
          >
            <font-awesome-icon :icon="['fas', 'eye']" />
          </button>
          <button
            v-if="ictPersonnelId == userId"
            class="btn btn-icon mr-1"
            style="background-color:#059886;color:#fff;"
            @click="$emit('open-modal', id)"
            aria-label="Open Modal"
            title="Complete"
          >
            <font-awesome-icon :icon="['fas', 'layer-group']" />
          </button>
        </div>

        <div v-else-if="status === 'Completed'">
          <button
            class="btn btn-icon mr-1"
            style="background-color:#059886;color:#fff;"
            @click="$emit('view', id)"
            aria-label="View Details"
            title="Show"
          >
            <font-awesome-icon :icon="['fas', 'eye']" />
          </button>
        </div>

        <div v-else-if="status === 'Draft'">
          <button
            class="btn btn-icon mr-1"
            style="background-color:#059886;color:#fff;"
            @click="$emit('receive-request', id)"
            aria-label="Confirm Request"
            title="Confirm"
            :disabled="isReceiving"
          >
            <font-awesome-icon :icon="['fas', 'circle-check']" />
          </button>
          <button
            class="btn btn-icon mr-1"
            style="background-color:#059886;color:#fff;"
            @click="$emit('view', id)"
            aria-label="View Details"
            title="Show"
          >
            <font-awesome-icon :icon="['fas', 'eye']" />
          </button>
        </div>
      </template>

      <template v-else-if="role === 'user' || role === 'gss_admin' || role === 'budget_admin'">
        <button
          class="btn btn-icon mr-1"
          style="background-color:#059886;color:#fff;"
          @click="$emit('view', id)"
          aria-label="View Details"
          title="Show"
        >
          <font-awesome-icon :icon="['fas', 'eye']" />
        </button>
      </template>
    </div>
  </template>

  <script>
  import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

  export default {
    name: 'ActionButtons',
    components: {
      FontAwesomeIcon
    },
    props: {
      role: {
        type: String,
        required: true
      },
      status: {
        type: String,
        required: true
      },
      id: {
        type: [Number, String],
        required: true
      },
      userId: {
        type: [Number, String],
        required: true
      },
      ictPersonnelId: {
        type: [Number, String],
        default: null
      },
      isReceiving: {
        type: Boolean,
        default: false
      }
    }
  };
  </script>
