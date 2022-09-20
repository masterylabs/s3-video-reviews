<template>
  <v-row justify="end" align="center" no-gutters>
    <template v-if="!type">
      <slot name="prepend" />
      <v-btn icon @click="type = 1">
        <v-icon>mdi-trash-can-outline</v-icon>
      </v-btn>
    </template>
    <template v-else>
      <m-tooltip value="Does NOT Delete S3 Bucket">
        <v-btn
          v-bind="localBtn"
          color="warning"
          depressed
          class="ml-2"
          @click="onLocal"
        >
          Delete Locally
        </v-btn>
      </m-tooltip>

      <m-tooltip value="Deletes S3 Bucket Also">
        <v-btn
          v-bind="fullBtn"
          color="error"
          depressed
          class="ml-2"
          @click="onFull"
        >
          Delete Full
        </v-btn>
      </m-tooltip>

      <v-btn v-bind="cancelBtn" @click="onCancel" depressed class="ml-2"
        >Cancel</v-btn
      >
    </template>
  </v-row>
</template>

<script>
import { mapActions } from 'vuex'

export default {
  props: {
    item: {
      type: Object,
      required: true,
    },
  },

  data() {
    return {
      type: '',
    }
  },

  computed: {
    localBtn() {
      return {
        loading: this.type === 'local',
        disabled: this.type === 'full',
      }
    },
    fullBtn() {
      return {
        loading: this.type === 'full',
        disabled: this.type === 'local',
      }
    },
    cancelBtn() {
      return {
        disabled: ['local', 'full'].includes(this.type),
      }
    },
  },

  methods: {
    ...mapActions({
      deleteBucketByKey: 'awsBuckets/deleteBucketByKey',
    }),

    async onLocal() {
      this.deleteBucket('local')
    },

    async onFull() {
      this.deleteBucket('full')
    },

    async deleteBucket(type) {
      this.type = type

      const success = await this.deleteBucketByKey({
        Key: this.item.name,
        region: this.item.region,
        type,
        id: this.item.id,
      })

      if (!success) {
        this.$app.error('Unable to complete delete ' + this.type)
        this.type = 1
      } else {
        this.$app.success('Bucket deleted!')
        this.$emit('deleted')
        this.type = ''
      }
    },

    onCancel() {
      if (this.type !== 1) {
        this.type = 1
      } else {
        this.type = ''
      }
    },
  },
}
</script>
