<template>
  <v-text-field
    :value="value"
    :loading="loading"
    :label="label"
    :placeholder="placeholder"
    :hint="hint"
    :filled="filled"
    :outlined="outlined"
    :dark="dark"
    :disabled="disabled"
    :autofocus="autofocus"
    :append-icon="icon"
    :prepend-icon="prependIcon"
    :hide-details="hideDetails"
    @click:append="onOpen"
    @input="onInput"
  >
    <template v-slot:prepend-inner>
      <slot name="prepend-inner" />
    </template>

    <template v-if="append" v-slot:append-outer>
      <slot name="append">
        <v-btn icon :disabled="!value" @click="onAppend">
          <v-icon v-text="`mdi-eye${!isPreview ? '-off' : ''}`"></v-icon>
        </v-btn>
      </slot>
    </template>
  </v-text-field>
</template>

<script>
import { nanoid } from 'nanoid'
export default {
  props: {
    append: Boolean,
    autofocus: Boolean,
    anyFormat: Boolean,
    hideDetails: Boolean,
    disabled: Boolean,
    outlined: Boolean,

    prependIcon: {
      type: String,
      default: '',
    },
    value: {
      type: String,
      default: '',
    },
    hint: {
      type: String,
      default: '',
    },
    icon: {
      type: String,
      default: 'mdi-image',
    },

    filled: {
      type: Boolean,
      default: false,
    },
    dark: Boolean,
    placeholder: {
      type: String,
      default: '',
    },
    label: {
      type: String,
      default: 'Image',
    },
    field: {
      type: Object,
      default() {
        return {}
      },
    },
  },

  data() {
    return {
      isAppend: false,
      loading: false,
      id: '',
    }
  },

  methods: {
    onAppend() {
      this.isAppend = !this.isAppend
      this.$emit('append', this.isAppend)
    },
    onInput(v) {
      this.$emit('input', v)
    },
    onOpen() {
      if (!window.parent) return this.$app.error('Not available')

      const message = {
        id: this.id,
        action: 'ml_wp_media',
        anyFormat: this.anyFormat,
      }
      window.parent.postMessage(JSON.stringify(message), '*')
    },
  },

  mounted() {
    const id = nanoid()

    this.id = id

    const IsJsonString = (str) => {
      try {
        JSON.parse(str)
      } catch (e) {
        return false
      }
      return true
    }

    window.addEventListener('message', (data) => {
      if (typeof data.data !== 'string' || !IsJsonString(data.data)) {
        return
      }

      const value = JSON.parse(data.data)

      // validate message
      if (
        !value.action ||
        !value.id ||
        value.action !== 'ml_wp_media' ||
        value.id !== id
      ) {
        return
      }

      this.$emit('input', value.url)
    })
  },
}
</script>
