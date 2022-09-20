<template>
  <aws-buckets-card v-bind="{ title, width }">
    <template v-slot:top>
      <slot name="top" />
    </template>
    <div class="grey lighten-5 rounded-xl mt-4 mb-7">
      <v-row justify="space-around" align="center">
        <v-col v-for="(step, index) in steps" :key="index" class="text-center">
          <aws-buckets-stepper-title v-bind="{ value: stepIndex, index }">
            {{ step.text }}
          </aws-buckets-stepper-title>
        </v-col>
      </v-row>
    </div>

    <v-window :value="stepIndex">
      <v-window-item v-for="step in steps" :key="step.value">
        <div v-if="step.title" class="title">{{ step.title }}</div>
        <p v-if="step.description">
          {{ step.description }}
        </p>
        <slot :name="step.value" />
      </v-window-item>
    </v-window>
  </aws-buckets-card>
</template>

<script>
export default {
  props: {
    value: {
      type: Number,
      default: 2,
    },
    title: {
      type: String,
      default: '',
    },
    width: {
      type: [String, Number],
      default: '',
    },
    steps: {
      type: Array,
      required: true,
    },
  },

  computed: {
    stepIndex() {
      return this.value - 1
    },
  },
}
</script>
