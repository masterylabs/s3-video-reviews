<template>
  <div>
    <component
      v-for="child in children"
      :key="child.id"
      :is="`adam-${child.type}-form`"
      :id="child.id"
    >
      <template v-slot:actions>
        <adam-item-actions v-model="more" v-bind="{ id, first, last }">
          <template v-slot:prepend>
            <adam-icon-toggle
              v-model="cols"
              icon="cellphone-link"
              tooltip="Responsive"
            />
          </template>
        </adam-item-actions>
      </template>

      <v-expand-transition>
        <adam-col-form v-if="cols" v-bind="{ id }" />
      </v-expand-transition>

      <v-expand-transition>
        <adam-box-form v-if="more" v-bind="{ id }" />
      </v-expand-transition>
    </component>
  </div>
</template>

<script>
  export default {
    props: {
      id: {
        type: String,
        required: true,
      },
      type: {
        type: String,
        required: true,
      },
      children: {
        type: Array,
        required: true,
      },
      first: Boolean,
      last: Boolean,
    },

    data() {
      return {
        more: false,
        cols: false,
      }
    },
  }
</script>
