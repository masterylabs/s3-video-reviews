<template>
  <div>
    <collection-header />

    <slot name="items" v-bind="{ items }">
      <v-row align="start" justify="start" v-bind="{ cols, sm, md, lg }">
        <v-col v-for="item in items" :key="item.id" class="shrink">
          <slot name="item" v-bind="{ item }" />
        </v-col>
      </v-row>
    </slot>
    <v-alert
      v-if="noData"
      border="left"
      colored-border
      color="primary"
      elevation="2"
      class="mt-12"
    >
      <slot name="no-data">No data</slot>
    </v-alert>
  </div>
</template>

<script>
import { mapState, mapGetters, mapActions } from 'vuex'
export default {
  props: {
    title: {
      type: String,
      default: '',
    },
    endpoint: {
      type: String,
      required: true,
    },
    cols: {
      type: [String, Number],
      default: 12,
    },
    sm: {
      type: [String, Number],
      default: 6,
    },
    md: {
      type: [String, Number],
      default: 4,
    },
    lg: {
      type: [String, Number],
      default: 3,
    },
  },

  computed: {
    ...mapState({
      collection: 'collection',
    }),
    ...mapGetters({
      items: 'collection/items',
      noData: 'collection/noData',
    }),
  },

  methods: {
    ...mapActions({
      load: 'collection/load',
    }),
  },

  async created() {
    await this.load(this.$props)
    this.ready = true
  },
}
</script>
