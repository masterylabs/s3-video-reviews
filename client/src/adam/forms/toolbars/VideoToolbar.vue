<template>
  <div>
    <v-toolbar dense flat color="grey lighten-5" style="overflow:hidden">
      <v-switch
        v-for="option in options"
        :key="option.value"
        :label="option.text"
        v-model="item.props[option.value]"
        class="mr-4"
        hide-details
      ></v-switch>
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
    </v-toolbar>

    <v-expand-transition>
      <adam-color-bar v-if="isColor" v-model="item.props.color" />
    </v-expand-transition>
  </div>
</template>

<script>
  import formMixin from '../../mixins/form'
  import options from '../../templates/video-options'

  export default {
    mixins: [formMixin],
    data() {
      return {
        isColor: false,
        options,
      }
    },
  }
</script>
