<template>
  <div>
    <v-text-field
      label="Display Name"
      v-model="form.meta.displayName"
      :placeholder="form.name"
      class="my-4"
    />
    <aws-buckets-icon-picker v-model="form.meta.icon" class="my-4" />
    <aws-buckets-color-picker v-model="form.meta.color" class="my-4" />
    <v-divider class="my-5"></v-divider>
    <v-row no-gutters>
      <v-btn
        color="primary"
        depressed
        v-bind="{ loading, disabled }"
        @click="saveChanges"
        >{{ isAdd ? 'Continue' : 'Save Changes' }}
      </v-btn>

      <v-spacer />
      <delete-folder
        v-if="!isAdd"
        :item-key="item.Key"
        @deleted="$emit('close')"
      />
    </v-row>
    <!-- hasChanges: {{ hasChanges }}, {{ disabled }} -->
  </div>
</template>

<script>
import { mapGetters, mapState, mapActions } from 'vuex'
export default {
  props: {
    isAdd: Boolean,
    item: {
      type: Object,
      required: false,
    },
  },

  computed: {
    ...mapState({
      awsBuckets: 'awsBuckets',
    }),
    ...mapGetters({
      bucketId: 'awsBuckets/bucketId',
      meta: 'awsBuckets/meta',
    }),
    hasChanges() {
      return this.dataStr !== JSON.stringify(this.form)
    },
    disabled() {
      return !this.isAdd && !this.hasChanges
    },
  },

  data() {
    return {
      loading: false,
      form: {
        meta: {},
      },
      dataStr: '',
    }
  },

  methods: {
    ...mapActions({
      updateItem: 'awsBuckets/updateItem',
    }),
    async saveChanges() {
      if (this.hasChanges) {
        this.loading = true
        await this.updateItem()
        this.dataStr = JSON.stringify(this.form)
        this.loading = false
      }

      this.$emit('close')
    },
  },

  created() {
    this.form = { ...this.item }
    this.dataStr = JSON.stringify(this.form)
  },
}
</script>
