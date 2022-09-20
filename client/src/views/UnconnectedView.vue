<template>
  <v-container fill-height>
    <v-row justify="center">
      <div class="text-center">
        <div class="text-h5 red lighten-5 mx-12 rounded-lg py-2 mb-2">
          Unable To Connect
        </div>
        <p class="red--text text-darken-4 mb-5">
          Unable to connect to your WordPress API.
        </p>

        <v-card width="400">
          <v-card-text class="text-center black--text">
            <div>
              <div class="title primary--text">Option 1. Try This...</div>

              Go to: WP Admin > Settings > Permalinks <br />
              Select option 2-5, and save changes. <br />
              <em class="caption grey--text">Come back and reload this page</em>
            </div>
            <v-divider class="mt-4"></v-divider>
            <div>
              <div class="title primary--text mt-5">
                Option 2. What about...
              </div>

              Log out of your WordPress admin, and back in! <br />
              <em class="caption grey--text"
                >Come back and see if we're connected</em
              >
            </div>
            <v-divider class="mt-4"></v-divider>
            <div>
              <div class="title primary--text mt-5">
                Option 3. Final check...
              </div>

              Log out of your WordPress admin, and back in! <br />
              <em class="caption grey--text"
                >Come back and see if we're connected</em
              >
            </div>
          </v-card-text>
        </v-card>
        <div class="text-h6 mt-5">Still no good....?</div>
        <p>
          Don't panic, we are here to help! <br />
          Simply send us a quick message through <br />
          our
          <a href="https://masterylabs.com/support" target="_blank"
            >support desk here >></a
          >
        </p>

        <v-btn x-large depressed color="primary" class="mt-5 mb-12">
          <v-icon class="mr-1">mdi-reload</v-icon>
          Reload Page
        </v-btn>
      </div>
    </v-row>
  </v-container>
</template>
