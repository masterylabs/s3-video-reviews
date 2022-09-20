<template>
  <div>
    <!-- {{ items }} -->
    <v-btn
      small
      depressed
      class="mb-n1x mr-1"
      v-for="btn in items"
      :key="btn.value"
      :icon="!!btn.icon"
      :disabled="disabled || (disabledKey && disabledKey[btn.value])"
      text
      @click="toggle(btn.value)"
    >
      <v-icon
        v-if="btn.icon"
        :color="item.props[btn.value] ? 'toggle-on' : 'toggle-off'"
        v-text="`mdi-${btn.icon}`"
        size="28"
      />

      <span
        v-if="btn.text"
        v-text="btn.text"
        class="font-weight-boldx title"
        :class="item.props[btn.value] ? 'toggle-on--text' : 'toggle-off--text'"
      />
    </v-btn>
  </div>
</template>

<script>
  // https://vuetifyjs.com/en/api/v-btn-toggle/#props
  import formMixin from '../mixins/form'
  export default {
    mixins: [formMixin],

    props: {
      focused: Boolean,
      multiple: Boolean,
      disabled: Boolean,

      items: {
        type: Array,
        required: true,
      },
      disabledKey: {
        type: Object,
        default: null,
      },
    },

    methods: {
      toggle(key) {
        this.item.props[key] = !this.item.props[key]
      },
    },
  }
</script>
