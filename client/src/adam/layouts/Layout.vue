<template>
  <div class="mt-n2">
    <div class="mb-3 mx-1">
      <slot name="links" />
    </div>
    <div class="mx-n3 mb-3">
      <slot name="header" />
    </div>

    <div>
      <slot name="main" />
    </div>

    <!-- <v-divider class="my-5" /> -->

    <div>
      <slot name="footer" />
    </div>

    <!-- <v-divider class="my-5" /> -->

    <v-row no-gutters justify="end" class="mt-12">
      <slot name="delete-btn" />
    </v-row>

    <slot />
    <adam-restore-snackbar />
  </div>
</template>
