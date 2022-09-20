<template>
  <v-text-field
    v-model="form.keyword"
    class="ml-4"
    label="Search..."
    hide-details
    rounded
    clearable
    prepend-inner-icon="mdi-magnify"
  />
</template>

<script>
import { mapGetters } from 'vuex'
export default {
  computed: {
    ...mapGetters({
      form: 'awsBuckets/filesForm',
    }),
  },
}
</script>
