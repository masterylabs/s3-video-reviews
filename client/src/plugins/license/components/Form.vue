<template>
  <form @submit.prevent="submit">
    <v-text-field
      v-model="form.email"
      autofocus
      :label="_('EMAIL')"
    ></v-text-field>
    <v-text-field
      v-model="form.password"
      :type="showPass ? 'text' : 'password'"
      :append-icon="`mdi-eye${showPass ? '' : '-off'}`"
      :label="_('PASSWORD')"
      @click:append="showPass = !showPass"
    ></v-text-field>

    <v-row no-gutters>
      <v-btn
        v-bind="{ loading }"
        :disabled="disabled || deleting"
        color="primary"
        type="submit"
      >
        {{ btnText || _('UPDATE_LICENSE') }}
      </v-btn>
      <v-spacer />
      <slot name="append" />

      <v-btn v-if="validLicense" class="ml-2" icon @click="more = !more">
        <v-icon>mdi-chevron-{{ more ? 'up' : 'down' }}</v-icon>
      </v-btn>
    </v-row>

    <v-expand-transition>
      <div v-if="more">
        <v-divider class="my-5"></v-divider>
        <v-btn
          small
          :disabled="disabled || loading"
          :loading="deleting"
          @click="deleteLicense"
          >Delete License</v-btn
        >
      </div>
    </v-expand-transition>

    <v-overlay v-if="updatingFeatures">
      <v-progress-circular size="200" indeterminate>
        Updating Features...
      </v-progress-circular>
    </v-overlay>
  </form>
</template>

<script>
import isEmail from 'validator/lib/isEmail'
import { mapGetters } from 'vuex'
export default {
  props: {
    btnText: {
      type: String,
      default: '',
    },
  },

  data() {
    return {
      loading: false,
      showPass: false,
      updatingFeatures: false,
      deleting: false,
      dataStr: '',
      more: false,
      form: {
        email: '',
        password: '',
      },
    }
  },

  computed: {
    ...mapGetters({
      validLicense: 'license/valid',
    }),
    disabled() {
      return !isEmail(this.form.email) || this.form.password.length < 3
    },
  },

  methods: {
    async submit() {
      if (this.disabled) return

      this.loading = true

      const success = await this.$store.dispatch('license/update', this.form)

      this.loading = false

      const licenseChanged =
        this.dataStr !== JSON.stringify(this.$store.getters['license/data'])

      if (success && licenseChanged) {
        this.updatingFeatures = true
        setTimeout(() => {
          parent.location.reload()
        }, 1000)
      }

      this.$emit('submitted', success)
    },

    async deleteLicense() {
      if (this.disabled) return

      this.deleting = true

      // $store.dispatch('license/update/', this.form)
      const success = await this.$app.post('client/license/delete', this.form)

      if (success) {
        this.updatingFeatures = true
        setTimeout(() => {
          parent.location.reload()
        }, 500)
      } else {
        this.deleting = false
      }
    },
  },

  mounted() {
    this.dataStr = JSON.stringify(this.$store.getters['license/data'])
  },
}
</script>
