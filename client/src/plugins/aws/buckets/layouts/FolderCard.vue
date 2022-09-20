<template>
  <div>
    <aws-buckets-card-layout-v2
      :id="item.Key"
      :name="item.meta.displayName || item.name"
      :tooltip="item.Key"
      :color="item.meta.color || color"
      :icon="item.meta.icon || 'folder'"
      v-on="{ select, edit }"
    />

    <aws-buckets-dialog v-model="isEdit" :title="item.Key">
      <aws-buckets-folder-form :item-key="item.Key" />
    </aws-buckets-dialog>
    <!-- <aws-buckets-folder-form :item-key="item.Key" @deleted="onDeleted" /> -->
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
export default {
  props: {
    item: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      isEdit: false,
    }
  },
  computed: {
    ...mapGetters({
      color: 'awsBuckets/color',
    }),
  },

  methods: {
    ...mapActions({
      setPath: 'awsBuckets/setPath',
    }),

    edit() {
      this.isEdit = !this.isEdit
    },
    onDeleted() {},
    select() {
      this.setPath(this.item.Key)
      // this.$router.push({ name: 'aws-bucket', params: { id: this.item.id } })
    },
  },
}
</script>
