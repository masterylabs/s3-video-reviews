<template>
  <v-icon icon @click="click">mdi-image</v-icon>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import { nanoid } from 'nanoid'
export default {
  data() {
    return {
      id: nanoid(),
    }
  },

  computed: {
    ...mapGetters({
      media: 'adam/media',
    }),
  },

  methods: {
    ...mapActions({
      onSelect: 'adam/onMediaSelect',
      openMedia: 'adam/openMedia',
    }),
    click() {
      this.openMedia(this.id)
      //   this.media.targetId = this.id
      //   this.media.dialog = true
    },
  },

  mounted() {
    this.onSelect((url) => {
      const itsMe = this.media.targetId === this.id
      if (itsMe) {
        this.$emit('input', url)
      }
    })
  },
}
</script>
