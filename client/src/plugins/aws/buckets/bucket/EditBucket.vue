<template>
  <div class="pt-6">
    <v-text-field
      label="Display Name"
      v-model="form.meta.displayName"
      :placeholder="form.name"
      outlined
    />
    <v-expand-transition>
      <aws-cloudfront-field v-model="form.cloudfront" v-if="advanced" />
    </v-expand-transition>
    <aws-buckets-icon-picker v-model="form.meta.icon" class="mb-5" />
    <aws-buckets-color-picker v-model="form.meta.color" class="my-4" />
    <v-divider class="my-5"></v-divider>
    <!-- <v-row no-gutters> -->
    <delete-bucket v-bind="{ item }" @deleted="$emit('deleted')">
      <template v-slot:prepend>
        <v-btn
          color="primary"
          depressed
          v-bind="{ loading, disabled }"
          @click="saveChanges"
          >Save Changes
        </v-btn>

        <v-spacer />

        <v-switch
          v-model="advanced"
          label="Advanced"
          class="mt-0 mr-2"
          hide-details
        ></v-switch>
      </template>
    </delete-bucket>

    <!-- </v-row> -->
  </div>
</template>

<script>
import { mapGetters, mapMutations } from 'vuex'
export default {
  props: {
    item: {
      type: Object,
      required: false,
    },
  },

  data() {
    return {
      loading: false,
      advanced: false,
      form: {
        cloudfront: '',
        meta: {},
      },
      dataStr: '',
    }
  },

  computed: {
    disabled() {
      return this.dataStr === JSON.stringify(this.form)
    },
    ...mapGetters({
      data: 'awsBuckets/data',
    }),
  },

  methods: {
    ...mapMutations({
      setData: 'awsBuckets/SET_DATA',
    }),
    async saveChanges() {
      this.loading = true
      const data = { ...this.form }

      await this.$app.bgPost(`/buckets/${data.id}`, data)
      this.dataStr = JSON.stringify(data)
      this.loading = false
      this.$emit('saved')

      const isActiveBucket = this.data && this.data.id === this.item.id

      if (isActiveBucket) {
        this.setData(this.form)
      }
    },
  },

  created() {
    this.form = { ...this.item }
    this.dataStr = JSON.stringify(this.form)
    this.advanced = !!this.form.cloudfront
  },
}
</script>
