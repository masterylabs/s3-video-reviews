<template>
  <v-row
    no-gutters
    v-bind="{ justify }"
    :style="confirm ? 'min-width: 160px' : ''"
  >
    <m-tooltip value="Delete" :disabled="!icon || confirm">
      <v-btn
        v-bind="{ small, depressed, loading }"
        :color="confirm ? 'error' : color"
        :icon="icon && !confirm"
        :class="btnClass"
        class="text-none"
        v-on="{ click }"
      >
        <v-icon v-if="icon && !confirm" color="grey"
          >mdi-trash-can-outline</v-icon
        >
        <slot v-else>Delete</slot>
      </v-btn>
    </m-tooltip>
    <v-btn
      v-if="confirm"
      v-bind="{ small, depressed }"
      :disabled="loading"
      class="ml-1 text-none"
      @click="confirm = false"
    >
      Cancel
    </v-btn>

    <slot v-if="!confirm" name="append" />
  </v-row>
</template>

<script>
export default {
  props: {
    icon: Boolean,
    loading: Boolean,
    small: Boolean,
    depressed: Boolean,
    noConfirm: Boolean,

    btnClass: {
      type: String,
      default: '',
    },
    color: {
      type: String,
      default: '',
    },
    justify: {
      type: String,
      default: 'start',
    },
  },
  data() {
    return {
      confirm: false,
    }
  },

  methods: {
    click() {
      if (!this.confirm && !this.noConfirm) {
        this.confirm = true
      } else {
        this.$emit('confirm')
      }
    },
  },
  watch: {
    loading(v) {
      if (!v) {
        this.confirm = false
      }
    },
  },
}
</script>
