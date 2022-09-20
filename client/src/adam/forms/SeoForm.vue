<template>
  <div>
    <!-- <v-text-field v-model="model.alt" label="Image ALT" filled class="mb-4" /> -->
    <v-row>
      <v-col cols="12" sm="6">
        <v-text-field
          v-model="model.title"
          label="Meta Title"
          :placeholder="model.name"
          counter
          hide-details
          maxlength="123"
          outlined
        />
      </v-col>
      <v-col cols="12" sm="6">
        <v-text-field
          v-model="model.image"
          label="Cover Image"
          outlined
          hide-details
        >
          <template v-slot:append>
            <adam-media v-model="model.image" />
          </template>
        </v-text-field>
      </v-col>
      <v-col cols="12" sm="6">
        <v-textarea
          v-model="model.description"
          label="Description"
          placeholder="About this page..."
          counter
          rows="1"
          auto-grow
          text
          maxlength="250"
          outlined
        />
      </v-col>
      <v-col cols="12" sm="6">
        <adam-keywords-field v-model="model.keywords" label="Meta Keywords" />
      </v-col>
    </v-row>

    <v-row>
      <v-switch
        v-for="item in items"
        :key="item.value"
        v-model="model[item.value]"
        :label="item.text"
        class="mx-4"
      />
    </v-row>
    <!-- <dev-raw :value="{ model }" /> -->
  </div>
</template>

<script>
export default {
  props: {
    fxAccess: Boolean,
    active: Boolean,
  },
  // google-site-verification
  data() {
    return {
      items: [
        // {
        //   text: 'Sponsored',
        //   value: 'sponsored',
        // },
        {
          text: 'No Follow',
          value: 'nofollow',
        },
        {
          text: 'No Index',
          value: 'noindex',
        },
      ],
    }
  },

  computed: {
    model: {
      get() {
        return this.$store.getters['adam/page'].seo
      },
      set(seo) {
        this.$store.commit('adam/SET_PAGE_PROP', { seo })
      },
    },
  },

  created() {
    if (!this.model) {
      this.model = {}
    }
  },
}
</script>
