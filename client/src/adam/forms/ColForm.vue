<template>
  <!-- 
  <v-row justify="center" align="center" no-gutters class="mb-n4">
    <div>
      Columns
    </div>
  </v-row> -->
  <v-row align="center" class="my-0">
    <v-col v-for="col in cols" :key="col.value">
      <adam-col-slider
        v-model="item.props[col.value]"
        :label="col.text"
        hide-details
      />
    </v-col>
  </v-row>
</template>

<script>
  import formMixin from '../mixins/form'

  export default {
    mixins: [formMixin],
    data() {
      return {
        cols: [
          // {
          //   text: 'Cols',
          //   value: 'cols',
          // },
          {
            text: 'Mobile',
            value: 'sm',
          },
          {
            text: 'Tablet',
            value: 'md',
          },
          {
            text: 'Desktop',
            value: 'lg',
          },
        ],
      }
    },
  }
</script>
