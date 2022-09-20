<template>
  <div>
    <v-text-field
      v-model="form.name"
      outlined
      autofocus
      label="Folder Name"
      placeholder="my-folder-name"
      :hint="sluggedName"
      v-on:keyup.enter="onEnter"
    ></v-text-field>

    <v-row no-gutters>
      <v-btn
        color="primary"
        :disabled="!sluggedName"
        :loading="loading"
        @click="next"
      >
        Continue
      </v-btn>
    </v-row>
  </div>
</template>

<script>
import mixin from './mixins'
import { slugify } from '../helpers'
import { mapActions } from 'vuex'
export default {
  mixins: [mixin],
  data() {
    return {
      loading: false,
    }
  },

  computed: {
    sluggedName() {
      return slugify(this.form.name)
    },
  },

  methods: {
    ...mapActions({
      createFolder: 'awsBuckets/createFolder',
    }),
    onEnter() {
      if (this.sluggedName) {
        this.next()
      }
    },
    async next() {
      this.loading = true

      const Key = await this.createFolder(this.form)

      if (Key) {
        this.data.Key = Key
        this.data.step = 2
      }
      this.loading = false
    },
  },
}
</script>
