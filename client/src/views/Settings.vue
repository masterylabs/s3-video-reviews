<template>
  <page-layout>
    <v-breadcrumbs :items="crumbs" />
    <v-row class="mt-1">
      <v-col>
        <v-card width="500" v-if="settings" class="pb-5 mb-6">
          <v-card-title>Settings</v-card-title>
          <v-card-text>
            <p>Get the following details from your Amazon AWS</p>
            <v-text-field
              v-model="settings.aws_access_key"
              label="Access Key ID"
              outlined
              @blur="doTrim('aws_access_key')"
            ></v-text-field>
            <v-text-field
              v-model="settings.aws_secret"
              label="Access Secret"
              :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
              :type="show1 ? 'text' : 'password'"
              @click:append="show1 = !show1"
              outlined
              @blur="doTrim('aws_secret')"
            ></v-text-field>

            <v-divider class="mb-7"></v-divider>

            <v-row>
              <v-col cols="6">
                <v-text-field
                  v-model="settings.google_analytics"
                  outlined
                  :label="m.lang.GOOGLE_ANALYTICS"
                  :placeholder="m.lang.GOOGLE_ANALYTICS_PLACEHOLDER"
                  hide-details
                ></v-text-field>
              </v-col>
              <v-col cols="6">
                <v-text-field
                  v-model="settings.fb_pixel"
                  outlined
                  :label="m.lang.FB_PIXEL"
                  :placeholder="m.lang.FB_PIXEL_PLACEHOLDER"
                  hide-details
                ></v-text-field>
              </v-col>
            </v-row>

            <!-- COOKIES   -->

            <v-expand-transition>
              <div v-if="settings.cookies_notice_active">
                <v-divider class="my-7"></v-divider>
                <v-textarea
                  v-model="settings.cookies_notice_text"
                  :label="m.lang.COOKIES_NOTICE_TEXT"
                  :placeholder="m.lang.COOKIES_NOTICE_TEXT_PLACEHOLDER"
                  :autofocus="autofocusCookiesText"
                  outlined
                  rows="2"
                />
                <v-text-field
                  v-model="settings.cookies_notice_btn_text"
                  :label="m.lang.COOKIES_NOTICE_BTN_TEXT"
                  :placeholder="m.lang.COOKIES_NOTICE_BTN_TEXT_PLACEHOLDER"
                  outlined
                />
              </div>
            </v-expand-transition>

            <v-divider class="mt-6"></v-divider>
          </v-card-text>

          <v-card-actions class="px-4" flat>
            <v-btn
              v-bind="{ loading, disabled: !hasChanges }"
              color="primary"
              @click="submit"
              >Save Changes
            </v-btn>
            <v-spacer />
            <v-switch
              v-model="settings.cookies_notice_active"
              :label="m.lang.COOKIES_NOTICE_ACTIVE"
              hide-details
              class="mt-0"
            />
            <!-- <m-tooltip value="Automatically generate thumbs">
              <v-switch
                v-model="settings.auto_thumbs"
                label="Auto Thumbs"
                color="success"
                hide-details
                class="mt-0"
              ></v-switch>
            </m-tooltip> -->
          </v-card-actions>
        </v-card>

        <!-- <aws-buckets-cors-snippet-card width="500" /> -->
      </v-col>
    </v-row>
    <!-- <m-code>
      {{ settings }}
    </m-code> -->
    <br />
    <br />
  </page-layout>
</template>

<script>
import { mapGetters } from 'vuex'
import settingsMixin from '../mixins/settings'
export default {
  mixins: [settingsMixin],

  data() {
    return {
      loading: false,
      testingConnection: false,
      showChimpField: false,
      show1: false,
      showAdvanced: false,
      crumbs: [
        {
          text: 'Home',
          disabled: false,
          to: {
            name: 'home',
          },
          exact: true,
        },
        {
          text: 'Settings',
          disabled: true,
        },
      ],
    }
  },

  computed: {
    ...mapGetters({
      settings: 'settings',
      hasChanges: 'hasChanges',
      access: 'access',
      config: 'config',
    }),
  },

  methods: {
    async submit() {
      this.loading = true
      await this.$store.dispatch('saveSettings')
      this.loading = false
    },

    doTrim(key) {
      this.settings[key] = this.settings[key].trim()
    },

    open(url) {
      window.open(url)
    },

    async testConnection() {
      this.testingConnection = true
      // save first
      await this.$app.get('mailchimp/ping')

      this.testingConnection = false
    },

    // validateCloudfront() {
    //   this.settings.aws_cloudfront = this.settings.aws_cloudfront.trim()
    //   if (this.settings.aws_cloudfront.indexOf('://') > -1) {
    //     this.settings.aws_cloudfront = this.settings.aws_cloudfront
    //       .split(':')
    //       .pop()
    //   }

    //   const len = this.settings.aws_cloudfront.length
    //   if (this.settings.aws_cloudfront.substring(len - 1) === '/') {
    //     this.settings.aws_cloudfront = this.settings.aws_cloudfront.substring(
    //       0,
    //       len - 1
    //     )
    //   }
    // },
  },

  async created() {
    if (!this.settings) {
      await this.$store.dispatch('loadSettings')
    }
    this.showAdvanced = !!this.settings.aws_cloudfront
  },
}
</script>
