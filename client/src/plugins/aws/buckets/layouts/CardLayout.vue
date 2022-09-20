<template>
  <v-hover v-slot="{ hover }">
    <v-card :elevation="hover || active ? 10 : 0" rounded="lg" width="330">
      <v-card-text class="text-center">
        <div class="mb-4">
          <v-icon v-bind="{ color: getColor }" size="120" @click="select"
            >mdi-{{ icon }}
          </v-icon>
        </div>
        <m-tooltip :value="tooltip || name">
          <v-btn
            v-bind="{ color: getColor }"
            class="title text-none"
            text
            @click="select"
          >
            <div class="text-truncate" style="max-width: 270px">
              {{ displayName || name }}
            </div>
          </v-btn>
        </m-tooltip>
      </v-card-text>
      <v-fade-transition>
        <div v-show="hover">
          <v-btn absolute right top icon @click="edit">
            <v-icon>mdi-dots-horizontal</v-icon>
          </v-btn>
        </div>
      </v-fade-transition>
      <v-dialog
        v-model="layout.cardEditDialog"
        width="340"
        :retain-focus="false"
      >
        <v-card>
          <slot name="edit" />

          <v-btn
            absolute
            right
            top
            icon
            class="mt-n2 mr-n2"
            @click="layout.cardEditDialog = false"
          >
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-card>
      </v-dialog>
    </v-card>
  </v-hover>
</template>
<script>
import { mapGetters } from 'vuex'
export default {
  props: {
    id: {
      type: [String, Number],
      required: true,
    },
    active: Boolean,
    icon: {
      type: String,
      default: 'bucket-outline',
    },
    color: {
      type: String,
      default: '',
    },
    defaultColor: {
      type: String,
      default: 'primary',
    },
    name: {
      type: String,
      default: '',
    },
    displayName: {
      type: String,
      default: '',
    },
    tooltip: {
      type: String,
      default: '',
    },
  },

  computed: {
    ...mapGetters({
      layout: 'awsBuckets/layout',
    }),
    getColor() {
      return this.color || this.defaultColor
    },
  },

  methods: {
    select() {
      this.$emit('select', this.id)
    },
    edit() {
      return this.$emit('edit')
    },
  },
}
</script>
