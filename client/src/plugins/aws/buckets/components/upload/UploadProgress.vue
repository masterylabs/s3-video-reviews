<template>
  <div>
    <div v-for="(item, i) in items" :key="i" class="mb-3">
      <v-progress-linear
        :color="item.progress === 100 ? 'success' : 'accent'"
        height="40"
        :value="item.progress"
        :striped="item.loading"
      >
        <v-row no-gutters class="mx-5" align="center">
          <div>{{ item.name }}</div>
          <v-spacer></v-spacer>
          <div class="mr-4">{{ item.progress }}%</div>
          <aws-buckets-upload-item-actions :item-key="item.Key" />
        </v-row>
      </v-progress-linear>
    </div>

    <v-row v-if="items.length" no-gutters justify="end">
      <v-btn
        small
        class="text-none"
        depressed
        :disabled="!isCompletedUploads"
        @click="removeAllUploaded"
      >
        Clear Uploaded
      </v-btn>
    </v-row>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
export default {
  computed: {
    ...mapGetters({
      items: 'awsBuckets/uploads',
      isCompletedUploads: 'awsBuckets/isCompletedUploads',
    }),
  },

  methods: {
    ...mapActions({
      removeAllUploaded: 'awsBuckets/removeAllUploaded',
    }),
  },
}
</script>
