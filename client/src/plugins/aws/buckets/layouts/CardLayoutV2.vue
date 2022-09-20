<template>
  <v-hover v-slot="{ hover }">
    <v-card :elevation="hover ? 10 : 0" rounded="lg" width="330">
      <v-card-text class="text-center">
        <div class="mb-4">
          <v-icon v-bind="{ color }" size="120" @click="select"
            >mdi-{{ icon }}
          </v-icon>
        </div>
        <m-tooltip :value="tooltip">
          <v-btn
            v-bind="{ color }"
            class="title text-none"
            text
            @click="select"
          >
            <div class="text-truncate" style="max-width: 270px">
              {{ name }}
            </div>
          </v-btn>
        </m-tooltip>
      </v-card-text>
      <v-fade-transition>
        <div v-show="hover">
          <v-btn absolute right top icon @click="toggleEdit">
            <v-icon>mdi-dots-horizontal</v-icon>
          </v-btn>
        </div>
      </v-fade-transition>
    </v-card>
  </v-hover>
</template>
<script>
export default {
  props: {
    id: {
      type: [String, Number],
      required: true,
    },
    icon: {
      type: String,
      default: 'bucket-outline',
    },
    color: {
      type: String,
      default: '',
    },
    name: {
      type: String,
      default: '',
    },
    tooltip: {
      type: String,
      default: '',
    },
  },

  methods: {
    toggleEdit() {
      this.$emit('edit')
    },
    select() {
      this.$emit('select', this.id)
    },
  },
}
</script>
