<template>
  <div>
    <ml-login-form endpoint="auth/login" @success="onSuccess">
      {{ m.lang.LOGIN_BTN }}
    </ml-login-form>

    <v-row cols="6" class="text-center">
      <v-col>
        <div>Trouble Signing In?</div>
        <v-btn class="text-none" text color="primary">{{
          m.lang.LOGIN_HELP_BTN
        }}</v-btn>
      </v-col>
      <v-col>
        <div>Trouble Signing In?</div>
        <v-btn class="text-none" text color="primary">{{
          m.lang.LOGIN_REGISTER_BTN
        }}</v-btn>
      </v-col>
    </v-row>
  </div>
</template>
