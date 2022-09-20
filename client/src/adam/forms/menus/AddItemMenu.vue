<template>
  <v-menu bottom left>
    <template v-slot:activator="{ on, attrs }">
      <v-btn icon v-bind="attrs" v-on="on">
        <v-icon>mdi-plus</v-icon>
      </v-btn>
    </template>

    <v-list>
      <v-list-item v-for="item in items" :key="item.value" @click="add(item)">
        <v-list-item-title>{{ item.text }}</v-list-item-title>
      </v-list-item>
    </v-list>
  </v-menu>
</template>

<script>
export default {
  data() {
    return {
      items: [
        {
          text: 'Title',
          value: 'text',
        },
        {
          text: 'Content',
          value: 'content',
        },
        {
          text: 'Button',
          value: 'btn',
        },
        {
          text: 'Buy Button',
          value: 'buy-btn',
        },
        {
          text: 'Video',
          value: 'video',
        },
        {
          text: 'Image',
          value: 'image',
        },
        {
          text: 'Links',
          value: 'links',
        },
        {
          text: 'Custom HTML',
          value: 'custom-html',
        },
      ],
    }
  },

  methods: {
    add(e) {
      this.$emit('add', { name: e.text, type: e.value })
    },
  },
}
</script>
