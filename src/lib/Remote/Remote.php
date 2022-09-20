<?php

namespace Masteryl\Remote;

class Remote
{
    protected $default_args = [
        'timeout' => 60,
    ];

    public $body;

    public $code;

    public function __get($key)
    {
        if (isset($this->{$key})) {
            return $this->{$key};
        }
    }

    public function setOption($key, $value)
    {
        $this->default_values[$key] = $value;
        return $this;
    }

    public function _post($url, $args = [])
    {
        $args['method'] = 'POST';
        return $this->_request($url, $args);
    }

    public function _get($url, $args = [])
    {
        $args['method'] = 'GET';
        return $this->_request($url, $args);
    }

    public function _request($url, $args = [])
    {
        $args = $this->parseArgs($args);

        // ee('request', [$url, $args]);

        $res = \wp_remote_request($url, $args);

        if (is_object($res) && !empty($res->errors)) {
            $this->body = $res; // json_encode($res->errors);
            $this->code = 400;
        } else {
            $this->code = $res['response']['code'];
            $this->body = $res['body'];

        }

        // ee($res);

        return $this;
    }

    public function isJson()
    {
        // already converted
        if (empty($this->body)) {
            return false;
        }

        if (is_object($this->body)) {
            return true;
        }

        json_decode($this->body);

        return json_last_error() === JSON_ERROR_NONE;

    }

    public function json()
    {
        if ($this->body) {

            $json = json_decode($this->body);
            if (json_last_error() === JSON_ERROR_NONE) {
                $this->body = $json;
            } else {
                $this->error = 'JSON';
            }
        }
        return $this;
    }

    public function getJson()
    {

        $json = (object) [];

        $json->code = $this->code;

        $json->body = $this->body;

        if (is_string($json->body)) {
            $json->body = json_decode($json->body);

            if (json_last_error() !== JSON_ERROR_NONE) {
                // error not json
                $json->body = $this->body;
                $json->json_error = true;
            }
        }

        return $json;
    }

    /**
     * Returns array, body, code
     */

    public function getData()
    {
        return [
            'body' => $this->body,
            'code' => $this->code,
        ];
    }

    private function parseArgs($args)
    {
        foreach ($this->default_args as $key => $val) {
            if (!isset($args[$key])) {
                $args[$key] = $val;
            }
        }

        return $args;
    }

    public static function __callStatic($name, $args = [])
    {
        $class = get_called_class();

        $method = "_{$name}";
        if (method_exists($class, $method)) {
            return (new static )->{$method}(...$args);
        }

    }
}
