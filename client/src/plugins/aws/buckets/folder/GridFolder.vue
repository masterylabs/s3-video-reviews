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
            <v-icon :color="color || 'secondary'" size="64">
              mdi-{{ item.meta.icon || 'folder' }}
            </v-icon>
          </div>
          <div
            class="font-weight-regular title text-truncate mx-auto"
            style="max-width: 206px"
          >
            <m-tooltip :value="item.prettyKey">
              <span :style="`color: ${color || '#111'}`">
                {{ item.meta.displayName || item.name }}
              </span>
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

        <!-- <m-code>
          {{ item }}
        </m-code> -->
      </v-card>
    </v-hover>

    <m-dialog v-model="dialog" :title="`Edit Folder - ${item.name}`" persistent>
      <edit-folder v-bind="{ item }" @close="dialog = false" />
    </m-dialog>
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
      dialog: false,
      overEdit: false,
    }
  },

  computed: {
    ...mapGetters({
      bucketColor: 'awsBuckets/color',
    }),
    color() {
      if (this.item.meta.color) {
        return this.item.meta.color
      }

      return this.bucketColor || ''
    },
  },

  methods: {
    ...mapActions({
      setPath: 'awsBuckets/setPath',
    }),
    click() {
      if (!this.overEdit) {
        this.setPath(this.item.Key)

        // this.$router.push({ name: 'aws-folder', params: { id: this.item.id } })
      }
    },
  },
}
</script>
