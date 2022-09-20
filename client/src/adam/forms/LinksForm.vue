<template>
  <div class="mt-4x">
    <v-row no-gutters class="mb-5" align="start">
      <!-- <v-col class="shrink lighten-3 text-center">
        <div class="text--secondary px-2 mb-2">Links</div>

        <adam-icon-btn icon="plus" tooltip="Add Link" mb="2" @click="addLink" />
        <adam-icon-btn
          v-model="more"
          icon="chevron-down"
          toggle-icon="chevron-up"
          tooltip="More"
        />
      </v-col> -->
      <v-col>
        <adam-btn-form
          v-for="(btn, i) in item.children"
          :key="btn.id"
          :id="btn.id"
          label="Link Text"
        >
          <template v-slot:actions>
            <adam-item-actions
              v-bind="{
                id: btn.id,
                first: i === 0,
                last: i === item.children.length - 1,
              }"
            />
          </template>
        </adam-btn-form>
      </v-col>
    </v-row>

    <v-row no-gutters class="mb-4 mt-n2 ml-2">
      <adam-icon-btn
        v-model="more"
        icon="chevron-down"
        toggle-icon="chevron-up"
        tooltip="More"
      />
      <adam-icon-btn icon="plus" tooltip="Add Link" mb="2" @click="addLink" />
    </v-row>

    <v-expand-transition>
      <div v-if="more">
        <v-row align="center" class="my-0">
          <v-col class="shrink">
            <adam-variant-field v-model="item.childProps.variant" />
          </v-col>
          <v-col class="shrink">
            <adam-size-field v-model="item.childProps.size" />
          </v-col>
          <v-col class="shrink">
            <adam-justify-field v-model="item.props.justify" />
          </v-col>

          <v-col class="shrink">
            <adam-color-toggle v-model="color" />
          </v-col>
        </v-row>
        <v-expand-transition>
          <div v-if="color">
            <adam-color-bar v-model="item.childProps.color" />
          </div>
        </v-expand-transition>

        <v-row class="my-0">
          <v-col>
            <v-slider
              label="Spacing X"
              v-model="item.childProps.mx"
              max="16"
              hide-details
            />
          </v-col>
          <v-col>
            <v-slider
              label="Spacing Y"
              v-model="item.childProps.my"
              max="16"
              hide-details
            />
          </v-col>
        </v-row>

        <v-row no-gutters class="my-0">
          <slot name="toggle" />
          <v-spacer />
          <slot name="actions" />
        </v-row>
        <slot />

        <v-divider class="my-2 mb-5" />
      </div>
    </v-expand-transition>

    <!-- <dev-raw :value="item.props" /> -->
  </div>
</template>

<script>
import formMixin from '../mixins/form'
export default {
  mixins: [formMixin],
  data() {
    return {
      color: false,
      more: false,
    }
  },

  methods: {
    addLink() {
      this.$store.commit('adam/ADD_CHILD', { id: this.id, type: 'btn' })
    },
  },
}
</script>
