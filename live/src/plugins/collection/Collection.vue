<template>
  <!-- toolbar  -->
  <v-toolbar
    ><v-badge :content="state.pagin.total" offset-x="-10">
      <v-toolbar-title> {{ title }} </v-toolbar-title>
    </v-badge>

    <!-- search  -->
    <v-text-field
      v-model="state.query.q"
      label="Search..."
      prepend-inner-icon="mdi-magnify"
      :loading="state.searching"
      variant="plain"
      class="mx-10"
      clearable
      hide-details
      v-on:keyup.enter="search"
      @click:clear="search"
    />
  </v-toolbar>

  <!-- Cards  -->
  <v-row>
    <v-col
      v-for="(item, index) in items"
      :key="index"
      cols="12"
      sm="6"
      md="4"
      lg="3"
    >
      <!-- collection item: {{ item.id }} -->
      <component
        v-if="itemComponent"
        :is="itemComponent"
        v-bind="{ item, index }"
      />
      <slot v-else name="item" v-bind="{ item, index }" />
      <!-- {{ item }} -->
    </v-col>
  </v-row>

  <!-- Pagination  -->
  <v-pagination
    class="mt-5"
    v-model="state.query.page"
    :length="state.pagin.pages"
    @update:model-value="onPagin"
  ></v-pagination>

  <code>{{ title }}, items: {{ items }}</code>
</template>

<script setup>
import { createCollection } from './create-collection'
import { computed } from 'vue'
const props = defineProps({
  name: {
    type: String,
    default: '',
  },
  title: {
    type: String,
    default: '',
  },
  endpoint: {
    type: String,
    default: '',
  },
  itemComponent: {
    type: String,
    default: '',
  },
  state: {
    type: Object,
    default: null,
  },
  collection: {
    type: Object,
    default: null,
  },
})

// let collection

// if (props.collection) {
//   collection = props.collection
//   console.log('collection exists')
// } else {
//   collection = createCollection(props)
//   console.log('no collection')
// }
const collection = props.collection || createCollection(props)

const { onPagin, search, load } = collection

// conditional computes

const items = props.collection
  ? computed(() => collection.items)
  : collection.items

const state = props.collection
  ? computed(() => collection.state)
  : collection.state

// ? props.collection
// : createCollection(props)

if (!props.collection) {
  load()
}
</script>
