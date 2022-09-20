<?php

namespace Masteryl\Modules\Client;

use Masteryl\Helpers\Encrypt;
use Masteryl\Remote\Remote;

class Host
{
    protected $app;

    protected $host_api;

    protected $bloginfo;

    protected $install_key;

    protected $auth;

    protected $license;

    protected $response;

    public function __construct($app)
    {
        $this->app = $app;

        $this->host_api = $app->clientOptions('host_api');

        $this->install_key = $this->app->option('install_key')->get();

    }

    public function __get($key)
    {
        if (isset($this->{$key})) {
            return $this->{$key};
        }
    }

    public function getLicense()
    {
        $code = $this->app->option('license')->get();

        if ($code) {
            $value = Encrypt::open($code, $this->install_key);
            $value = is_array($value) ? $value : false;
        } else {
            $value = null;
        }

        return compact('value', 'code');
    }

    /**
     * Handshake
     */

    public function handshake($token)
    {
        return $this->request('POST', 'handshake', null, ['X-Token' => $token]);
    }

    private function request($method, $endpoint, $body = null, $headers = null)
    {

        $args = [
            'method' => $method,
            'headers' => [
                'X-Install' => $this->install_key,
            ],
        ];

        if ($body) {
            $args['body'] = $body;
        }

        if ($headers) {
            foreach ($headers as $key => $val) {
                $args['headers'][$key] = $val;
            }
        }

        $url = $this->host_api . '/' . $endpoint;

        $res = Remote::request($url, $args)->json();

        $this->response = $res;

        return $res->code && $res->code < 300;

    }

}
