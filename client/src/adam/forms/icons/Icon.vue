<template>
  <v-tooltip
    :bottom="!tooltipTop"
    :top="tooltipTop"
    :disabled="!tooltip || !value"
  >
    <template v-slot:activator="{ attrs, on }">
      <v-icon
        v-bind="attrs"
        v-on="on"
        v-text="`mdi-${icon}`"
        :color="noColor ? '' : value ? color : offColor"
        :class="spacing.class"
      />
    </template>
    <span v-if="tooltip" v-text="tooltip" />
  </v-tooltip>
</template>

<script>
  import spacingMixin from '../../mixins/spacing'
  export default {
    mixins: [spacingMixin],
    props: {
      tooltipTop: Boolean,
      value: {
        type: Boolean,
        default: true,
      },
      tooltip: {
        type: String,
        default: null,
      },
      noColor: Boolean,
      icon: {
        type: String,
        default: 'check',
      },
      color: {
        type: String,
        default: 'toggle-on',
      },
      offColor: {
        type: String,
        default: 'toggle-off',
      },
    },
  }
</script>
