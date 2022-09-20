<template>
  <div>
    <v-row justify="center" align="center" no-gutters class="mb-n4">
      <div>
        Padding
      </div>
      <adam-lock-toggle v-model="locked" class=" mt-n1 mr-n8" @input="onLock" />
    </v-row>

    <v-row>
      <v-col v-for="padding in items" :key="padding.key">
        <v-slider
          v-model="item.props[padding.key]"
          :label="padding.text"
          max="16"
          thumb-label
          @input="onInput"
        ></v-slider>
      </v-col>
    </v-row>
  </div>
</template>

<script>
  import spacingFormMixin from '../mixins/spacing-form'
  export default {
    mixins: [spacingFormMixin],
    data() {
      return {
        items: [
          {
            text: 'Left',
            key: 'pl',
          },
          {
            text: 'Right',
            key: 'pr',
          },
          {
            text: 'Top',
            key: 'pt',
          },
          {
            text: 'Buttom',
            key: 'pb',
          },
        ],
      }
    },
  }
</script>
