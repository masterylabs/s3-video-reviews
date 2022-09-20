<?php

namespace Masteryl\Modules\Client;

use Masteryl\Helpers\Encode;
use Masteryl\Helpers\Encrypt;
use Masteryl\Remote\Remote;

class Client
{

    protected $app;

    protected $options;

    protected $install_key;

    protected $auth;

    protected $license;

    public function __construct($app, $options = null)
    {
        $this->app = $app;

        if (!$options) {
            $options = $app->clientOptions();
        }

        $this->options = $options;

        $this->install_key = $app->option('install_key')->get();
    }

    public function __get($key)
    {
        if (method_exists($this, $key)) {
            return $this->{$key}();
        }
    }

    public function deactivate()
    {
        return $this->requestHost('POST', 'deactivate');
    }

    public function activate()
    {
        return $this->requestHost('POST', 'activate');
    }

    /**
     * Version 1
     */

    public function register($data)
    {
        // convert to array

        if (is_object($data)) {
            $data = Encode::toArray($data);
        }

        return $this->requestHost('POST', 'register', $data);
    }

    public function updateLicense($email, $password)
    {

        $this->auth = 'Basic ' . base64_encode($email . ':' . $password);

        // ee($email . $password);

        $res = $this->requestHost('POST', 'license');

        if (!empty($res->body->data)) {

            $code = Encrypt::bundle($res->body->data, $this->install_key);
            $this->app->option('license')->update($code);

        }

        return $res;
    }

    public function deleteLicense($email, $password)
    {

        $this->auth = 'Basic ' . base64_encode($email . ':' . $password);

        // ee($email . $password);

        $res = $this->requestHost('POST', 'license');

        if ($res->code < 300) {
            $this->app->option('license')->destroy();
        }

        return $res;
    }

    public function getUpdate()
    {
        $res = $this->requestHost('GET', 'update');

        if (!empty($res->code) && $res->code < 300) {
            return $res->body;
        }

        return false;
    }

    private function requestHost($method, $endpoint, $headerData = null)
    {

        $data = [
            'plugin_id' => $this->app->id,
            'client_ip' => $this->app->client_ip,
        ];

        foreach ($this->options['bloginfo'] as $i) {
            $data[$i] = get_bloginfo($i);
        }

        $args = [
            'method' => $method,
            'headers' => [
                'X-Token' => Encode::toBase($data),
            ],
        ];

        $keys = $this->options['header_keys'];

        if ($headerData) {
            $args['headers'][$keys['data']] = Encode::toBase($headerData);
        }

        if ($this->install_key) {
            $args['headers'][$keys['install']] = $this->install_key;
        }

        if ($this->auth) {
            $args['headers'][$keys['auth']] = $this->auth;
        }

        $url = $this->options['host_api'] . '/' . $endpoint;

        // return;
        // ee($url, $args);

        $res = Remote::request($url, $args)->json();

        $body = $res->body;

        if (!empty($body->update_options)) {
            foreach ($body->update_options as $key => $val) {
                $this->app->option($key)->update($val);

                // install key
                if (isset($this->{$key})) {
                    $this->{$key} = $val;
                }
            }
        }

        if (!empty($body->delete_options)) {
            foreach ($body->delete_options as $key => $val) {
                $this->app->option($key)->destroy();
            }
        }

        return $res;
    }

}
