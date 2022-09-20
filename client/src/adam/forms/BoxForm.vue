<template>
  <div>
    <adam-sheet-form :id="id">
      <template v-slot:options-append>
        <v-switch
          v-model="item.props.hideOverlay"
          label="Hide Overlay"
          class="mx-2"
        />
      </template>
    </adam-sheet-form>
  </div>
</template>

<script>
import formMixin from '../mixins/form'
import { colsMin } from '../templates/cols'

export default {
  mixins: [formMixin],
  data() {
    return {
      colsMin,
    }
  },
}
</script>
