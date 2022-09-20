<template>
  <v-card width="400" elevation="12">
    <v-card-title>{{ _('LICENSE_ACTIVATION') }}</v-card-title>
    <v-card-text>
      <p>
        {{ _('LICENSE_ACTIVATION_INFO') }}
      </p>
      <license-form btn-text="Activate License" />
    </v-card-text>
  </v-card>
</template>

<script>
  export default {}
</script>
