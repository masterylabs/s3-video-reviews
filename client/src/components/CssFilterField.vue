<template>
  <div>
    <v-row class="mb-5">
      <v-col v-for="preset in presets" :key="`preset${preset.value}`">
        <v-btn
          :outlined="value !== preset.value"
          :disabled="disabled"
          depressed
          color="primary"
          :class="{ 'black--text': primaryIsLight }"
          block
          @click="onPreset(preset.value)"
          >{{ preset.text }}</v-btn
        >
      </v-col>
    </v-row>

    <v-slider
      v-for="slider in sliders"
      :key="slider.key"
      v-model="model[slider.key]"
      v-bind="slider.attrs"
      thumb-label
      @input="onSlide"
    />
  </div>
</template>

<script>
import themeMixin from '@/mixins/theme'
const getNumberValue = (str, key) => {
  if (str.indexOf(`${key}(`) < 0) return 0
  const [, b] = str.split(`${key}(`)
  let [val] = b.split(')')
  return parseInt(val)
}

export default {
  mixins: [themeMixin],
  props: {
    disabled: Boolean,
    advanced: Boolean,
    value: {
      type: String,
      default: '',
    },
  },

  data() {
    return {
      lastVal: '',
      model: {
        blur: 5,
        grayscale: 25,
        brightness: 50,
      },
      presets: [
        {
          text: 'Standard',
          value: 'blur(5px) grayscale(25%) brightness(50%)', // blur(7px) brightness(50%)
        },
        {
          text: 'Dialog',
          value: 'blur(0px) grayscale(0%) brightness(50%)',
        },
        {
          text: 'Pop',
          value: 'blur(7px) grayscale(0%) brightness(100%)',
        },
        {
          text: 'BW',
          value: 'grayscale(100%) grayscale(100%) brightness(100%)',
        },
        {
          text: 'Clear',
          value: 'blur(0px) grayscale(0%) brightness(100%)',
        },
      ],
      sliders: [
        {
          key: 'blur',
          attrs: {
            label: 'Blur',
            max: 18,
          },
        },
        {
          key: 'grayscale',
          attrs: {
            label: 'Grayscale',
          },
        },
        {
          key: 'brightness',
          attrs: {
            label: 'Brightness',
            max: 200,
            min: 1,
          },
        },
      ],
    }
  },

  methods: {
    onSlide() {
      let val = `blur(${this.model.blur || 0}px)`
      if (this.model.grayscale) val += ` grayscale(${this.model.grayscale}%)`
      if (this.model.brightness) val += ` brightness(${this.model.brightness}%)`
      this.$emit('input', val)
    },
    onPreset(value) {
      this.lastVal = value
      this.$emit('input', value)
    },
    loadValue() {
      this.lastVal = this.value
      for (const k in this.model) {
        this.model[k] = getNumberValue(this.value, k)
      }
    },
  },

  created() {
    if (this.value) this.loadValue()
  },

  watch: {
    value(v) {
      if (v !== this.lastValue) {
        this.loadValue()
      }
    },
  },
}
</script>
