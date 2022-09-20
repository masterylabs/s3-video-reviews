<template>
  <v-breadcrumbs :items="items">
    <template v-slot:item="{ item }">
      <v-breadcrumbs-item
        class="primary--text"
        :class="{ 'ml-pointer': !item.disabled }"
        :disabled="item.disabled"
        @click="onSelect(item)"
      >
        <v-icon
          v-if="item.icon"
          :color="!item.disabled ? color : ''"
          class="mr-1"
        >
          mdi-{{ item.icon }}
        </v-icon>
        {{ item.text }}
      </v-breadcrumbs-item>
    </template>
  </v-breadcrumbs>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
export default {
  data() {
    return {
      prepend: [
        // {
        //   text: 'WP Buckets',
        //   to: {
        //     name: 'home',
        //   },
        // },
        {
          text: 'Buckets',
          to: {
            name: 'aws-buckets',
          },
        },
      ],
    }
  },

  computed: {
    ...mapGetters({
      crumbs: 'awsBuckets/crumbs',
      color: 'awsBuckets/color',
    }),
    items() {
      return [...this.prepend, ...this.crumbs]
    },
  },

  methods: {
    ...mapActions({
      select: 'awsBuckets/setPath',
    }),
    onSelect(item) {
      if (item.to) {
        return this.$router.push(item.to)
      }

      this.select(item.value)
    },
  },
}
</script>
