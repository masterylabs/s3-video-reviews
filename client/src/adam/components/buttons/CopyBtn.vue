<template>
  <v-tooltip bottom>
    <template v-slot:activator="{ attrs, on }">
      <v-btn v-bind="attrs" v-on="on" @click="click" icon>
        <v-icon>mdi-link</v-icon>
      </v-btn>
    </template>
    <span v-text="text" />
  </v-tooltip>
</template>

<script>
  export default {
    props: {
      value: {
        type: String,
        required: true,
      },
      text: {
        type: String,
        default: 'Copy Link',
      },
    },

    methods: {
      click() {
        this.$copyText(this.value).then(() => {
          this.$app.success('Copied To Clipboard')
        })
      },
    },
  }
</script>
