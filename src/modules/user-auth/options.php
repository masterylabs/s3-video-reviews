<?php

// override these in the config folder

return [
    'meta_key' => 'user_auth',
    'meta_key_prefix' => true,
    'token_model' => false, //AuthToken::class,
    'token_len' => 64,
    // 'unauthorized_message' => 'No Auth',
];
