<template>
  <adam-form-layout v-bind="{ more }">
    <template v-slot:main>
      <v-col>
        <div style="position: relative" class="adam-admin-content">
          <m-code-field
            v-model="item.htmlContent"
            :on="on"
            hide-details
            prepend-inner-icon="mdi-chevron-down"
            label="HTML Code"
            :data-item-id-input="item.id"
          />
        </div>
      </v-col>
    </template>

    <template v-slot:more>
      <v-col>
        <adam-toggle-field v-model="item.props.textAlign" :items="align" />
      </v-col>
    </template>

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
import align from '../templates/text-align'
export default {
  mixins: [formMixin],
  data() {
    return {
      more: false,
      menu: false,
      align,
      on: {
        'click:prepend-inner': this.toggleMore,
      },
    }
  },

  methods: {
    toggleMore() {
      this.more = !this.more
    },
  },
}
</script>

<style>
.adam-admin-content .ql-toolbar {
  padding-left: 30px !important;
}
</style>
