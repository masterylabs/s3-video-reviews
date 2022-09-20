<template>
  <div>
    <v-toolbar dense flat color="grey lighten-5" style="overflow:hidden">
      <adam-toggle-field
        v-model="item.props.variant"
        :items="variants"
        class="mr-4"
      />
      <adam-toggle-field
        v-model="item.props.size"
        :items="sizes"
        class="mr-4"
      />

      <v-switch
        v-model="item.props.block"
        label="Block"
        class="mr-4"
        hide-details
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
  import align from '../../templates/text-align'
  import format from '../../templates/text-format'

  // btn
  import variants from '../../templates/variants'
  import sizes from '../../templates/sizes'

  export default {
    mixins: [formMixin],
    data() {
      return {
        variants,
        sizes,

        isColor: false,
        align,
        format,
      }
    },
  }
</script>
