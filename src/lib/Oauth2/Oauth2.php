<?php

namespace Masteryl\Oauth2;

use Masteryl\Helpers\Url;
use Masteryl\Oauth2\Traits\Getters;
use Masteryl\Oauth2\Traits\Methods;
use Masteryl\Oauth2\Traits\Routes;
use Masteryl\Oauth2\Traits\Setters;
use Masteryl\Remote\Remote;

class Oauth2
{
    use Getters, Methods, Routes, Setters;

    protected $req;

    protected $res;

    protected $url;

    protected $client_id;

    protected $client_secret;

    protected $redirect_uri;

    protected $scopes;

    protected $response_type = 'code';

    public $access_token;

    public $expires_in;

    public $expires_at;

    protected $scope_key = 'scope';

    // OPTIONAL

    protected $authorize_params;

    protected $response_code;

    // dev
    protected $dev_use_debug_data = true;

    // protected $refresh_token_on_reqest_fail = true;

    // protected $token_refreshed = false;

    private $state_values;

    private function request($endpoint, $params = [])
    {

        $url = Url::append($this->url . '/' . $endpoint, $params);

        $args = [
            'headers' => $this->getHeaders(),
        ];

        $res = Remote::post($url, $args)->json();

        $body = $res->body;

        $this->response_code = $res->code;

        // append expires_at
        if (is_object($body) && !empty($body->expires_in)) {
            $body->expires_at = current_time('U') + (int) $body->expires_in;

            // if (method_exists($this, 'setToken')) {
            //     $this->setToken($body);
            // }
        }

        return $body;
    }

    public function getHeaders()
    {
        return [
            'Authorization' => 'Basic ' . base64_encode($this->getClientId() . ':' . $this->getClientSecret()),
        ];
    }

}
