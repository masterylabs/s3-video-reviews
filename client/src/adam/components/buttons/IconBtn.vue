<template>
  <v-tooltip bottom :disabled="!tooltip">
    <template v-slot:activator="{ attrs, on }">
      <v-btn
        v-bind="{
          ...attrs,
          large,
          class: spacing.class,
          icon: true,
          color: value ? activeColor : color,
          disabled,
        }"
        v-on="{
          ...on,
          click,
        }"
      >
        <v-icon v-text="`mdi-${toggleIcon && value ? toggleIcon : icon}`" />
      </v-btn>
    </template>
    <span v-if="tooltip" v-text="tooltip" />
  </v-tooltip>
</template>

<script>
  import spacingMixin from '../../mixins/spacing'
  export default {
    mixins: [spacingMixin],
    props: {
      disabled: Boolean,
      isToggle: Boolean,
      value: {
        type: Boolean,
        default: null,
      },
      large: Boolean,
      tooltip: {
        type: String,
        default: null,
      },
      icon: {
        type: String,
        default: 'check',
      },
      toggleIcon: {
        type: String,
        default: '',
      },
      color: {
        type: String,
        default: '',
      },
      activeColor: {
        type: String,
        default: 'primary',
      },
    },

    methods: {
      click() {
        if (this.value !== null || this.isToggle) {
          this.$emit('input', !this.value)
        } else {
          this.$emit('click')
        }
        // can be used for toggle
      },
    },
  }
</script>
