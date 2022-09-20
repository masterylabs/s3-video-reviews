<template>
  <div>
    <v-btn color="accent" outlined @click="stepper.dialog = true">
      <v-icon class="mr-1">mdi-plus</v-icon>
      New Offer
    </v-btn>
    <v-dialog v-model="stepper.dialog" persistent width="700">
      <v-card class="pb-4">
        <v-toolbar dense color="secondary" dark>
          <v-toolbar-title>New Offer</v-toolbar-title>
          <v-spacer />
          <v-btn icon @click="closeDialog">
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-toolbar>
        <v-row
          no-gutters
          align="center"
          justify="space-between"
          class="text-center py-8"
        >
          <v-col v-for="(step, index) in steps" :key="step.text">
            <v-row align="center" justify="center" class="mx-auto">
              <div
                class="subtitle-1 rounded-circle mr-2"
                style="width: 30px; height: 30px; line-height: 30px"
                :class="getNumberClass(index)"
              >
                <v-icon v-if="stepper.value > index" dark class="mt-n1"
                  >mdi-check</v-icon
                >
                <span v-else>{{ index + 1 }}</span>
              </div>
              <span class="subtitle-1">{{ step.text }}</span>
            </v-row>
          </v-col>
        </v-row>
        <v-card-text>
          <v-window v-model="stepper.value">
            <v-window-item>
              <m-add-offer-bucket />
            </v-window-item>
            <v-window-item>
              <m-add-offer-cors />
            </v-window-item>
            <v-window-item>
              <m-add-offer-customise />
            </v-window-item>
          </v-window>
        </v-card-text>

        <!-- <v-card-actions>
          <v-btn @click="next">Next</v-btn>
          <v-btn @click="back">Back</v-btn>
        </v-card-actions> -->
      </v-card>
    </v-dialog>
    <!-- <m-code>
      {{ stepper }}
    </m-code> -->
  </div>
</template>

<script>
import { mapGetters, mapMutations } from 'vuex'
export default {
  data() {
    return {
      steps: [
        {
          text: 'Add Bucket',
          value: 'bucket',
        },
        {
          text: 'Set CORS',
          value: 'cors',
        },
        {
          text: 'Offer Details',
          value: 'customise',
        },
      ],
    }
  },

  computed: {
    ...mapGetters({
      stepper: 'addOffer/stepper',
    }),
  },

  methods: {
    ...mapMutations({
      clearForm: 'addOffer/CLEAR_FORM',
    }),
    next() {
      this.stepper.value++
    },
    back() {
      this.stepper.value--
    },
    getNumberClass(index) {
      if (index === this.stepper.value) {
        return 'primary white--text'
      }

      if (this.stepper.value > index) {
        return 'success white--text'
      }

      return 'grey lighten-2'
    },
    closeDialog() {
      this.stepper.dialog = false
      this.clearForm()
    },
  },
}
</script>
