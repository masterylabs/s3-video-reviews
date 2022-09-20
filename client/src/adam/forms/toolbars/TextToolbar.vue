<template>
  <div>
    <v-toolbar dense flat color="grey lighten-5" style="overflow:hidden">
      <adam-toggle-field
        v-model="item.props.size"
        :items="size"
        class="mr-4 d-none d-md-flex"
      />

      <adam-toggle-field
        v-model="item.props.size"
        :items="sizeMin"
        class="mr-4 d-flex d-md-none"
      />

      <adam-toggle-field
        :value="formatValue"
        :items="format"
        multiple
        class="mr-4"
        @input="onFormat"
      />

      <v-badge :color="item.props.color" dot offset-x="10" offset-y="10">
        <v-btn
          icon
          :color="isColor ? 'primary' : 'grey'"
          @click="isColor = !isColor"
        >
          <v-icon>mdi-palette</v-icon>
        </v-btn>
      </v-badge>

      <v-spacer />

      <adam-toggle-field v-model="item.props.align" :items="align" />
    </v-toolbar>

    <v-expand-transition>
      <adam-color-bar v-if="isColor" v-model="item.props.color" />
    </v-expand-transition>
  </div>
</template>

<script>
  import formMixin from '../../mixins/form'
  import size from '../../templates/text-size'
  import align from '../../templates/text-align'
  import format from '../../templates/text-format'

  const formatKeys = format.map((a) => a.value)

  export default {
    mixins: [formMixin],
    data() {
      return {
        isColor: false,
        size,
        align,
        format,
        formatValue: [],
        sizeMin: size.filter((item, index) => index < 3),
      }
    },

    methods: {
      onFormat(arr) {
        formatKeys.forEach((key) => {
          this.item.props[key] = arr.indexOf(key) > -1
        })
      },
    },

    created() {
      formatKeys.forEach((key) => {
        if (this.item.props[key]) {
          this.formatValue.push(key)
        }
      })
    },
  }
</script>
