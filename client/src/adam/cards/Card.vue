<template>
  <v-hover v-slot="{ hover }">
    <v-card
      max-width="400"
      :elevation="hover || more ? 11 : 4"
      rounded="lg"
      class="mb-6"
    >
      <v-card-text class="text-center secondary white--text py-2">
        <div class="title text-center font-weight-regular"><slot /></div>
      </v-card-text>
      <v-img
        v-if="src"
        height="200"
        width="100%"
        :src="src"
        class="mx-auto ml-pointer card-image"
        @click="onSelect"
      >
        <v-fade-transition>
          <div v-if="!hover" class="card-image-mask"></div>
        </v-fade-transition>
      </v-img>

      <v-row
        v-if="!src"
        style="height: 200px"
        justify="center"
        align="center"
        class="ml-pointer"
        no-gutters
        @click="onSelect"
      >
        <v-icon
          v-if="!src"
          size="130"
          color="secondary"
          v-text="`mdi-${icon}`"
        />
      </v-row>

      <v-divider class="pt-1" />
      <v-card-actions>
        <v-tooltip v-for="action in actions" :key="action.icon" bottom>
          <template v-slot:activator="{ attrs, on }">
            <v-btn
              icon
              v-bind="attrs"
              v-on="on"
              :loading="action.loading"
              class="mr-1"
              @click="action.click"
            >
              <v-icon color="secondary" v-text="action.icon" />
            </v-btn>
          </template>
          <span v-text="action.text" />
        </v-tooltip>

        <slot name="actions-append" />
        <v-spacer />

        <v-btn text color="secondary" :loading="selecting" @click="onSelect"
          >Select</v-btn
        >
        <v-btn icon color="secondary" @click="more = !more">
          <v-icon>mdi-chevron-{{ more ? 'up' : 'down' }}</v-icon>
        </v-btn>
      </v-card-actions>

      <v-expand-transition>
        <div v-if="more">
          <v-divider />
          <v-card-text>
            <slot name="more" />
            <v-row justify="end" no-gutters class="mt-5">
              <slot name="delete-btn" />
            </v-row>
          </v-card-text>
        </div>
      </v-expand-transition>
    </v-card>
  </v-hover>
</template>

<script>
export default {
  props: {
    actions: {
      type: Array,
      required: true,
    },
    icon: {
      type: String,
      default: 'timer-outline',
    },
    src: {
      type: String,
      default: '',
    },
  },

  data() {
    return {
      more: false,
      selecting: false,
    }
  },

  methods: {
    onSelect() {
      this.selecting = true
      this.$emit('select')
    },
  },
}
</script>

<style scoped>
.card-image {
  position: relative;
}
.card-image-mask {
  position: absolute;
  left: 0;
  top: 0;
  height: 100%;
  width: 100%;
  background: rgba(0, 0, 0, 0.3);
}
</style>
