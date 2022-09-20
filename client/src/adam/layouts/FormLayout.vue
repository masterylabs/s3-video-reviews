<template>
  <div>
    <!-- Main  -->
    <div>
      <v-row>
        <slot name="main" />
      </v-row>
    </div>

    <v-expand-transition>
      <div v-if="more">
        <slot name="more-prepend" />
        <v-row align="start">
          <v-col>
            <v-row align="center" justify="start" no-gutters class="my-0 mb-3">
              <slot name="more" />
            </v-row>
          </v-col>
          <v-col class="shrink">
            <slot name="parent-actions" />
          </v-col>
        </v-row>
        <slot name="more-append" />
      </div>
    </v-expand-transition>

    <v-expand-transition>
      <div v-if="color && more">
        <slot name="color" />
      </div>
    </v-expand-transition>

    <v-fade-transition>
      <div v-if="more">
        <slot />
      </div>
    </v-fade-transition>
  </div>
</template>

<script>
export default {
  props: {
    more: Boolean,
    color: Boolean,
  },
}
</script>
