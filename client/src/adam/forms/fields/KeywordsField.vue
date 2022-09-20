<template>
  <v-combobox
    v-model="model"
    :label="label"
    :search-input.sync="search"
    multiple
    persistent-hint
    small-chips
    outlined
    @input="onInput"
    @keyup="onKeyup"
  >
    <template v-slot:selection="{ attrs, item, select, selected }">
      <v-chip
        v-bind="attrs"
        :input-value="selected"
        close
        @click="select"
        @click:close="remove(item)"
      >
        {{ item }}
      </v-chip>
    </template>
  </v-combobox>
</template>

<script>
export default {
  props: {
    value: {
      type: String,
      default: '',
    },
    label: {
      type: String,
      default: 'Keywords',
    },
  },

  data() {
    return {
      model: [],
      search: '',
    }
  },

  beforeMount() {
    if (this.value) {
      this.model = this.value.split(', ')
    }
  },

  methods: {
    onKeyup({ key }) {
      if (key === 'Enter' || !this.search) {
        return
      }

      if (this.search.indexOf(',') > -1) {
        this.parseValue(this.search)
        this.search = ''
      }
    },

    onInput() {
      this.$emit('input', this.model.join(', '))
    },

    parseValue(keywordStr) {
      const items = keywordStr.split(',')
      items.forEach((item) => {
        item = item.trim()
        // trim item
        if (item && this.model.indexOf(item) < 0) {
          this.model.push(item)
        }
      })

      this.onInput()
    },

    remove(item) {
      const index = this.model.indexOf(item)
      this.model.splice(index, 1)
      this.onInput()
    },
  },
}
</script>
