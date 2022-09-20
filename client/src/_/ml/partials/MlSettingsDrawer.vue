<template>
  <v-navigation-drawer
    v-model="l.settings.drawer"
    :permanent="l.settings.drawer"
    app
    right
  >
    <v-toolbar>
      <v-spacer />
      <v-btn icon>
        <v-icon>mdi-close</v-icon>
      </v-btn>
    </v-toolbar>
    <developer-view v-if="l.settings.view == 'developer'" />
  </v-navigation-drawer>
</template>
