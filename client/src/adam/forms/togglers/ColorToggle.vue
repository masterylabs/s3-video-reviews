<template>
  <v-tooltip bottom :disabled="!tooltip">
    <template v-slot:activator="{ attrs, on }">
      <span v-bind="attrs" v-on="on">
        <v-badge :color="color" dot offset-x="10" offset-y="10">
          <v-btn icon :class="nudgeUp ? 'my-n2' : ''">
            <v-icon
              v-text="`mdi-${bg ? 'format-color-fill' : 'palette'}`"
              :color="value ? 'primary' : ''"
              @click="$emit('input', !value)"
            />
          </v-btn>
        </v-badge>
      </span>
    </template>
    <span v-text="tooltip" />
  </v-tooltip>
</template>

<script>
  export default {
    props: {
      nudgeUp: Boolean,
      bg: Boolean,
      value: Boolean,
      color: {
        type: String,
        default: '',
      },
      tooltip: {
        type: String,
        default: '',
      },
    },
  }
</script>
