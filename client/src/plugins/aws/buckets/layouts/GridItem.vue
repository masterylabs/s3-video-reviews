<template>
  <v-hover v-slot="{ hover }">
    <v-card :elevation="hover ? 10 : 0" rounded="lg" width="230">
      <v-card-text class="text-center">
        <div class="mb-4">
          <v-icon v-bind="{ color }" size="60" @click="select"
            >mdi-{{ icon }}
          </v-icon>
        </div>
        <m-tooltip :value="tooltip">
          <div
            class="ml-pointer body-1 mt-n2 font-weight-medium text-truncate"
            style="max-width: 210px"
            @click="select"
          >
            {{ name }}
          </div>
        </m-tooltip>
      </v-card-text>
      <v-fade-transition>
        <div v-show="hover">
          <v-btn absolute right top icon @click="edit">
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
    // id: {
    //   type: [String, Number],
    //   required: true,
    // },
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
    edit() {
      this.$emit('edit')
    },
    select() {
      this.$emit('select')
    },
  },
}
</script>
