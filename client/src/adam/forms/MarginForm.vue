<template>
  <div>
    <v-row justify="center" align="center" no-gutters class="mb-n4">
      <div>
        Margin
      </div>
      <adam-lock-toggle v-model="locked" class=" mt-n1 mr-n8" @input="onLock" />
    </v-row>

    <v-row>
      <v-col v-for="m in items" :key="m.key">
        <adam-margin-slider
          v-model="item.props[m.key]"
          :label="m.text"
          @input="onInput"
        />
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
            key: 'ml',
          },
          {
            text: 'Right',
            key: 'mr',
          },
          {
            text: 'Top',
            key: 'mt',
          },
          {
            text: 'Buttom',
            key: 'mb',
          },
        ],
      }
    },
  }
</script>
