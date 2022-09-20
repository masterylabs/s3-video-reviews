<template>
  <div>
    <v-hover v-slot="{ hover }">
      <v-card
        :elevation="hover || dialog ? 10 : 0"
        rounded="lg"
        v-on="{ click }"
      >
        <v-card-text class="text-center">
          <div>
            <v-icon :color="item.meta.color || 'accent'" size="64">
              mdi-{{ item.meta.icon || 'bucket' }}
            </v-icon>
          </div>
          <div
            class="font-weight-regular title text-truncate mx-auto"
            :style="{ color: item.meta.color || '#111', maxWidth: '206px' }"
          >
            <m-tooltip :value="item.name" :disabled="!item.meta.displayName">
              {{ item.meta.displayName || item.name }}
            </m-tooltip>
          </div>
        </v-card-text>
        <v-fade-transition>
          <div v-show="hover || dialog">
            <v-hover @input="overEdit = $event">
              <v-btn absolute right top icon @click="dialog = true">
                <v-icon>mdi-dots-horizontal</v-icon>
              </v-btn>
            </v-hover>
          </div>
        </v-fade-transition>
      </v-card>
    </v-hover>

    <m-dialog v-model="dialog" :title="`Edit Bucket - ${item.name}`" persistent>
      <edit-bucket
        v-bind="{ item }"
        @saved="dialog = false"
        @deleted="onDeleted"
      />
    </m-dialog>
  </div>
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
      dialog: false,
      overEdit: false,
    }
  },

  methods: {
    ...mapActions({
      removeItemById: 'collection/removeItemById',
    }),
    click() {
      if (!this.overEdit) {
        this.$router.push({ name: 'aws-bucket', params: { id: this.item.id } })
      }
    },
    onDeleted() {
      this.dialog = false
      this.removeItemById(this.item.id)
    },
  },
}
</script>
