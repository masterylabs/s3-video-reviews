<template>
  <v-hover v-slot="{ hover }">
    <div>
      <v-btn
        v-bind="{ loading, disabled: disabled && !hover }"
        v-on="{ click }"
        :color="!disabled ? 'primary' : ''"
        :depressed="disabled"
      >
        Save Changes
      </v-btn>
    </div>
  </v-hover>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
export default {
  data() {
    return {
      loading: false,
    }
  },

  computed: {
    ...mapGetters({
      hasChanges: 'adam/hasChanges',
    }),
    disabled() {
      return !this.hasChanges
    },
  },

  methods: {
    ...mapActions({
      save: 'adam/save',
      // saveToBucket: 'adam/saveToBucket',
    }),
    async click() {
      this.loading = true
      await this.save()

      this.loading = false
    },
  },
}
</script>
