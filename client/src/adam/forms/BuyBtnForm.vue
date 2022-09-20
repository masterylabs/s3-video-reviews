<template>
  <adam-btn-form :id="id">
    <template v-slot:text-append="{ focused }">
      <adam-toggle-form
        style="min-width: 96px"
        v-bind="{ id, items, focused }"
        multiple
        :disabled-key="{ cart: item.opts.src }"
      />
    </template>

    <template v-slot:toggle>
      <slot name="toggle" />
    </template>
    <template v-slot:actions>
      <slot name="actions" />
    </template>

    <slot />
  </adam-btn-form>
</template>

<script>
import formMixin from '../mixins/form'

export default {
  mixins: [formMixin],
  data() {
    return {
      items: [
        {
          icon: 'cart',
          value: 'cart',
        },
        {
          icon: 'credit-card',
          value: 'cards',
        },
        {
          // text: 'PP',
          icon: 'alpha-p-box',
          value: 'paypal',
        },
      ],
    }
  },
}
</script>
