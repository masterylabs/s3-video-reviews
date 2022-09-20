<template>
  <adam-form-layout v-bind="{ more, color }">
    <template v-slot:main>
      <v-col>
        <adam-video-field
          hide-details
          :autofocus="!item.props.src"
          v-model="item.props.src"
          :duration="item.duration"
          :service="item.service"
          v-on="{ duration, service }"
        >
          <template v-slot:prepend-inner>
            <adam-menu-toggle v-model="more" />
          </template>
        </adam-video-field>
      </v-col>
      <v-col>
        <v-text-field
          v-model="item.props.poster"
          label="Video Image"
          hide-details
          outlined
        >
          <template v-slot:append>
            <adam-media v-model="item.props.poster" />
          </template>
        </v-text-field>
      </v-col>
    </template>

    <template v-slot:more>
      <v-row align="center">
        <v-switch
          v-for="option in options"
          :key="option.value"
          :label="option.text"
          v-model="item.props[option.value]"
          class="mx-3"
          hide-details
        />
      </v-row>
    </template>

    <template v-slot:more-append>
      <v-row>
        <v-col>
          <adam-elevation-slider v-model="item.props.elevation" hide-details />
        </v-col>
        <v-col>
          <adam-rounded-slider
            v-model="item.props.rounded"
            hide-details
            class="my-3x"
          />
        </v-col>
      </v-row>
    </template>

    <adam-color-bar slot="color" v-model="item.props.color" class="pt-3" />

    <template v-slot:parent-toggle>
      <slot name="toggle" />
    </template>

    <template v-slot:parent-actions>
      <slot name="actions" />
    </template>

    <slot />
  </adam-form-layout>
</template>

<script>
import formMixin from '../mixins/form'
import options from '../templates/video-options'
// import V3 from '../../_/auth/_/buy-now-button/V3.vue'

export default {
  mixins: [formMixin],
  data() {
    return {
      more: false,
      color: false,
      options,
    }
  },
  methods: {
    duration(n) {
      this.item.duration = n
    },
    service(value) {
      this.item.service = value
    },
  },
  // components: { V3 },
}
</script>
