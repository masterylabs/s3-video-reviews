<template>
  <v-menu
    offset-y
    rounded="md"
    open-on-hover
    :close-on-click="false"
    :close-on-content-click="false"
    :close-delay="closeDelay"
    :min-width="minWidth"
    :dark="dark"
  >
    <template v-slot:activator="{ on, attrs }">
      <v-avatar v-if="avatar" v-bind="attrs" v-on="on">
        <img :src="avatar" />
      </v-avatar>

      <v-btn
        v-else
        :color="primary ? 'primary' : ''"
        :text="!primary"
        :depressed="primary"
        :dark="dark"
        v-bind="attrs"
        v-on="on"
        class="text-none"
        @click="onRootClick"
      >
        <v-icon v-if="icon" :class="{ 'mr-1': text }">{{ icon }}</v-icon>
        {{ text }}
        <v-icon v-if="items && items.length">mdi-chevron-down</v-icon>
      </v-btn>
    </template>

    <ml-list :value="value" :items="items" @click="$emit('click', $event)" />
  </v-menu>
</template>

<script>
  export default {
    props: {
      dark: Boolean,
      minWidth: {
        type: [Number, String],
        default: '200',
      },
      avatar: {
        type: String,
        default: '',
      },

      value: {
        type: [Number, String],
        default: null,
      },
      closeDelay: {
        type: [String, Number],
        default: 500,
      },
      primary: {
        type: Boolean,
        default: true,
      },
      text: {
        type: String,
        default: 'Save',
      },
      icon: {
        type: String,
        default: '',
      },
      items: {
        type: Array,
        default() {
          return []
        },
      },
      onHover: {
        type: Function,
        default() {},
      },
      click: {
        type: [Function, Boolean],
        default: null,
      },
    },

    methods: {
      onRootClick() {
        if (!this.click) return
        if (typeof this.click == 'function') return this.click()
        this.$emit('click') // boolean true
      },
    },
  }
</script>
