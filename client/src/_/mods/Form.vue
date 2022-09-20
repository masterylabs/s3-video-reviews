<template>
  <div>
    <v-row>
      <v-col
        v-for="field in form"
        :key="field.key"
        :cols="cols[field.key] ? cols[field.key] : field.cols ? field.cols : 12"
      >
        <component
          :is="`m-${field.type || 'text'}-field`"
          v-bind="field"
          hide-details
        />
      </v-col>
    </v-row>

    <dev-raw :value="{ form, model }" />
  </div>
</template>

<script>
  export default {
    props: {
      value: {
        type: Object,
        default() {
          return {}
        },
      },
      form: {
        type: Array,
        default() {
          return []
        },
      },
      cols: {
        type: Object,
        default() {
          return {}
        },
      },
    },

    data() {
      return {
        model: {},
      }
    },

    computed: {
      activeSlots() {
        const value = {}
        for (const k in this.$slots) value[k] = true
        return value
      },
    },

    beforeMount() {
      this.model = { ...this.value }
    },
  }
</script>
