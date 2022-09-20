<template>
  <!-- <div> -->
  <adam-sheet-form :id="id">
    <template v-slot:append>
      <v-row align="center" class="my-0">
        <v-col>
          <adam-col-slider label="Column" v-model="item.childProps.cols" />
        </v-col>
        <v-col>
          <adam-col-slider
            label="Offset"
            max="11"
            v-model="item.childProps.offset"
          />
        </v-col>
      </v-row>

      <v-text-field
        v-model="item.name"
        label="Panel Name"
        hide-details
        class="mb-3"
      ></v-text-field>
    </template>
    <template v-slot:options-prepend>
      <v-switch
        v-model="item.props.noGutters"
        label="No Gutters"
        class="mr-4"
      />
      <v-switch
        v-model="item.props.hideOverlay"
        label="Hide Overlay"
        class="mr-4"
      />
    </template>
  </adam-sheet-form>
  <!-- </div> -->
</template>

<script>
import formMixin from '../mixins/form'
export default {
  mixins: [formMixin],
  created() {
    if (!this.item.childProps) {
      this.item.childProps = {}
    }
  },
}
</script>
