<template>
  <div>
    <template v-if="children && children.length">
      <component
        :is="`adam-${child.type}-form`"
        v-for="child in children"
        :key="child.id"
        :id="child.id"
        :block-id="id"
        class="mb-4"
      >
        <template v-slot:actions>
          <v-sheet min-width="248" class="text-right" flat>
            <adam-chevron-toggle v-model="show" />
            <adam-icon-btn
              v-model="cols"
              icon="cellphone-link"
              tooltip="Responsive"
              is-toggle
              ml="2"
            />

            <adam-move-up-btn
              :disabled="index == 0"
              class="ml-2"
              @click="moveUp"
            />
            <adam-move-down-btn :disabled="last" @click="moveDown" />
            <adam-duplicate-btn class="ml-2" @click="duplicate" />
            <adam-remove-btn class="ml-2" @click="remove" />
          </v-sheet>
        </template>

        <v-expand-transition>
          <adam-col-form v-if="cols" v-bind="{ id }" />
        </v-expand-transition>

        <v-expand-transition>
          <div v-if="show">
            <adam-box-form class="pt-5" :id="id" />
          </div>
        </v-expand-transition>
      </component>
    </template>
  </div>
</template>

<script>
import panelMixin from '../mixins/panel'
export default {
  mixins: [panelMixin],

  data() {
    return {
      show: false,
      overActions: false,
      cols: false,
    }
  },

  methods: {
    addText() {
      this.$store.commit('adam/ADD_CHILD', { id: this.id, type: 'text' })
    },
    moveUp() {
      this.$store.commit('adam/MOVE_UP', this.id)
    },

    moveDown() {
      this.$store.commit('adam/MOVE_DOWN', this.id)
    },
    duplicate() {
      this.$store.commit('adam/CLONE', this.id)
    },
    remove() {
      this.$store.commit('adam/REMOVE', this.id)
    },
  },
}
</script>
