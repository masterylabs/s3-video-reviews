<?php

namespace Masteryl\Packages\Aweber;

use Masteryl\Oauth2\Oauth2;

class Auth extends Oauth2
{
    protected $url = 'https://auth.aweber.com/oauth2';

    protected $scopes = [
        'account.read',
        'list.read',
        'list.write',
        'subscriber.read',
        'subscriber.write',
    ];

    protected $redirect_uri = 'auth.aweber.callback';

    // public function __construct($app = null, $clientId = false, $clientSecret = false)
    // {

    //     $this->app = $app;

    //     if ($clientId) {
    //         $this->client_id = $sett->aweber_client_id;
    //     }

    //     if ($clientSecret) {
    //         $this->client_secret = $sett->clientSecret;
    //     }

    // }

}
