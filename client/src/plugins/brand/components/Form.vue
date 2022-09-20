<template>
  <div>
    <v-card flat :loading="loading">
      <v-card class="mb-5" min-width="250">
        <v-card-title> Brand </v-card-title>
        <v-card-text>
          <div v-for="field in fields.brand" :key="field.value">
            <component
              v-if="customFields[field.value]"
              :is="customFields[field.value]"
              :label="field.text"
            />

            <v-text-field
              v-else
              v-model="settings[field.value]"
              :label="field.text"
              v-on="{ input }"
            ></v-text-field>
          </div>
        </v-card-text>
      </v-card>

      <v-card class="mb-5">
        <v-card-title> Access </v-card-title>
        <v-card-text>
          <v-select
            v-for="field in fields.access"
            :key="field.value"
            v-model="settings[field.value]"
            :label="field.text"
            multiple
            :items="brand[field.items]"
          />

          <v-checkbox
            v-for="field in fields.options"
            v-model="settings[field.value]"
            :key="field.value"
            :label="field.text"
          />
        </v-card-text>
      </v-card>
    </v-card>

    <!-- <ml-json :value="fields.access" /> -->

    <!-- fields.access: {{ fields.access[1] }} -->
  </div>
</template>
<script>
import { mapGetters, mapState } from 'vuex'
import brandMixin from '../mixins/brand'
export default {
  mixins: [brandMixin],
  data() {
    return {
      loading: false,
      customFields: {
        slug: 'brand-slug-field',
      },
    }
  },

  computed: {
    ...mapState({
      brand: 'brand',
    }),
    ...mapGetters({
      settings: 'brand/settings',
      fields: 'brand/fields',
    }),
  },

  methods: {
    input() {
      if (this.settings.is_active) {
        this.setBrand()
      }
    },
  },
}
</script>
