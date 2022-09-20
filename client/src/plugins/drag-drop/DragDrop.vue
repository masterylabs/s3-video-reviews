<template>
  <div
    :draggable="!disabled"
    @dragstart="dragstart(index)"
    @dragenter="!disabled && dragenter(index)"
    @dragend="dragend"
    @drop="drop"
    ondragover="return false"
  >
    <div
      v-if="index === dragOver && dragAbove && isMyGroup"
      class="orange lighten-5 py-5"
      :class="spacerClass"
    />
    <slot />
    <div
      v-if="index === dragOver && dragBelow && isMyGroup"
      class="orange lighten-5 py-5"
      :class="spacerClass"
    />
  </div>
</template>

<script>
import { mapGetters, mapMutations } from 'vuex'
export default {
  props: {
    disabled: Boolean,
    index: {
      type: Number,
      default: null,
    },
    spacerClass: {
      type: String,
      default: '',
    },
    id: {
      type: String,
      default: 'drop-drag',
    },
  },

  // mounted() {
  //   this.setProp({ groupId: this.id })
  // },

  computed: {
    ...mapGetters({
      dragItem: 'drag-drop/dragItem',
      dragOver: 'drag-drop/dragOver',
      groupId: 'drag-drop/groupId',
    }),

    dragAbove() {
      return this.dragItem > this.dragOver
    },

    dragBelow() {
      return this.dragItem < this.dragOver
    },

    isMyGroup() {
      return this.groupId === this.id
    },
  },

  methods: {
    ...mapMutations({
      setProp: 'drag-drop/SET',
    }),

    dragstart(i) {
      this.setProp({ groupId: this.id })

      this.$emit('start')
      this.setProp({ dragItem: i })
    },
    dragenter(i) {
      if (!this.isMyGroup) return
      this.setProp({ dragOver: i })
    },
    dragend() {
      if (!this.isMyGroup) return

      this.$emit('end')
      this.setProp({ dragOver: -1, dragItem: -1 })
      this.isMe = false
    },
    drop() {
      if (!this.isMyGroup) return

      if (this.dragItem !== this.dragOver) {
        this.$emit('drag-drop', { from: this.dragItem, to: this.dragOver })
      }
    },
  },
}
</script>
