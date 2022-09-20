<template>
  <div>
    <!-- <dev-raw :value="items[0]" /> -->
    <v-fade-transition group>
      <adam-item
        v-for="(item, i) in items"
        :key="i"
        v-bind="item"
        v-on="{ message }"
        :theme="theme"
      />
    </v-fade-transition>
  </div>
</template>

<script>
// import { findItems } from './helpers/find'
// import { jsonClense } from './helpers/obj'
import liveMixin from './mixins/live'

export default {
  props: {
    body: {
      type: Object,
      default: null,
    },
    theme: {
      type: Object,
      default: null,
    },
    checkout_url: {
      type: String,
      default: '',
    },
  },
  mixins: [liveMixin],
}
</script>
