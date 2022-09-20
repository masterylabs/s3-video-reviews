<template>
  <v-expansion-panel-header
    :class="disabled ? 'grey--text text--darken-1' : ''"
  >
    <v-row no-gutters class="mr-3" align="center">
      <div class="text-capitalize">
        <slot />
      </div>
      <v-spacer />

      <v-slide-x-reverse-transition>
        <v-btn
          v-if="timed"
          small
          color="timed"
          depressed
          :disabled="disabled"
          class="my-n2 ml-3"
        >
          Timed
        </v-btn>
      </v-slide-x-reverse-transition>

      <v-slide-x-reverse-transition>
        <adam-disabled-notice v-if="disabled" />
      </v-slide-x-reverse-transition>
    </v-row>

    <v-tooltip v-if="draggable" right :disabled="!disabled && timed">
      <template v-slot:activator="{ attrs, on }">
        <div
          v-bind="attrs"
          v-on="on"
          class="is-draggable px-1"
          :class="
            disabled ? 'error' : timed ? 'timed' : draggable ? 'accent' : ''
          "
        />
      </template>
      <span v-text="disabled ? 'Disabled' : 'Timed'" />
    </v-tooltip>
  </v-expansion-panel-header>
</template>

<script>
export default {
  props: {
    draggable: Boolean,
    disabled: Boolean,
    timed: Boolean,
  },
}
</script>

<style scoped>
.is-draggable {
  position: absolute;
  left: 0;
  top: 0;
  height: 100%;
}
</style>
