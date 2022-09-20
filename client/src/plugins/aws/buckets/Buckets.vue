<template>
  <v-container>
    <collection-collection
      title="Buckets"
      endpoint="/buckets"
      cols="12"
      sm="6"
      md="4"
      lg="3"
    >
      <template v-slot:items="{ items }">
        <v-row class="mb-6">
          <v-col
            v-for="item in items"
            cols="12"
            sm="6"
            md="4"
            lg="3"
            :key="item.id"
          >
            <grid-bucket v-bind="{ item }" />
          </v-col>
        </v-row>
      </template>

      <template v-slot:no-data> No buckets </template>
    </collection-collection>
  </v-container>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
export default {
  computed: {
    ...mapGetters({
      items: 'collection/items',
      data: 'collection/data',
      access: 'access',
    }),
  },
  methods: {
    ...mapActions({
      removeItemById: 'collection/removeItemById',
      updateItem: 'collection/updateItem',
    }),
  },
}
</script>
