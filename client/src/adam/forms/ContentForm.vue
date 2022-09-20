<template>
  <adam-form-layout v-bind="{ more }">
    <template v-slot:main>
      <v-col>
        <div style="position:relative" class="adam-admin-content">
          <quill-editor
            v-model="item.htmlContent"
            :autofocus="!item.htmlContent"
          />
          <adam-menu-toggle
            v-model="more"
            style="position:absolute;left:6px;top:13px"
          />
        </div>
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

  export default {
    mixins: [formMixin],
    data() {
      return {
        more: false,
        menu: false,
      }
    },
  }
</script>

<style>
  .adam-admin-content .ql-toolbar {
    padding-left: 30px !important;
  }
</style>
