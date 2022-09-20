<template>
  <adam-form-layout v-bind="{ more, color }">
    <template v-slot:main>
      <v-col>
        <v-textarea
          v-model="item.textContent"
          label="Text"
          rows="1"
          :autofocus="!item.textContent"
          auto-grow
          hide-details
          outlined
          @focus="focused = true"
          @blur="focused = false"
        >
          <template v-slot:prepend-inner>
            <adam-menu-toggle v-model="more" />
          </template>

          <template v-slot:append>
            <adam-input-toggle-field
              v-model="item.props.textSize"
              v-bind="{ focused }"
              :items="size"
              dense
              borderless
              textfield
            />
            <!--             
            <adam-toggle-field
              v-model="item.props.align"
              :items="align"
              borderless
            /> -->
          </template>
        </v-textarea>
      </v-col>
    </template>

    <template v-slot:more>
      <v-col class="shrink">
        <adam-toggle-field
          :value="formatValue"
          :items="format"
          multiple
          @input="onFormat"
        />
      </v-col>
      <v-col class="shrink">
        <adam-toggle-field
          v-model="item.props.textAlign"
          :items="align"
          xborderless
        />
      </v-col>
      <v-col>
        <adam-color-toggle v-model="color" :color="item.props.textColor" />
      </v-col>
    </template>

    <adam-color-bar v-model="item.props.textColor" opacity slot="color" />

    <template v-slot:parent-toggle>
      <slot name="toggle" />
    </template>

    <template v-slot:parent-actions>
      <slot name="actions" />
    </template>

    <slot />
  </adam-form-layout>
</template>

<script>
import formMixin from '../mixins/form'
import size from '../templates/text-size'
import align from '../templates/text-align'
import format from '../templates/text-format'

const formatKeys = format.map((a) => a.value)

export default {
  mixins: [formMixin],
  data() {
    return {
      focused: false,
      more: false,
      color: false,
      size,
      align,
      format,
      formatValue: [],
    }
  },
  methods: {
    onFormat(arr) {
      this.formatValue = arr
      formatKeys.forEach((key) => {
        this.item.props[key] = arr && arr.indexOf(key) > -1
      })
    },
  },

  mounted() {
    formatKeys.forEach((key) => {
      if (this.item.props[key]) {
        this.formatValue.push(key)
      }
    })
  },
}
</script>
