<?php

namespace Masteryl\Request;

class Request
{
    protected $app;

    protected $request_method;

    protected $request_path;

    protected $request_uri;

    protected $_headers;

    protected $_auth_header_keys = ['authorization', 'x_auth'];

    private $_base_url;

    private $_current_url;

    private $_data = [];

    private $_replaced_params = [];

    public function __construct($app = null)
    {
        $this->app = $app;

        $this->request_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';

        // ee($_SERVER);

        $this->request_method = isset($_SERVER['REQUEST_METHOD']) ? strtolower($_SERVER['REQUEST_METHOD']) : 'get';

        $i = explode('?', $this->request_uri);

        $this->request_path = '/' . trim(array_shift($i), '/');

        // support sub directory folders : added 1.1
        $path = $this->urlParts('path');

        if (strpos($this->request_path, $path) === 0) {
            $this->request_path = substr($this->request_path, strlen($path));
        }

        if (!empty($_REQUEST)) {
            foreach ($_REQUEST as $key => $val) {
                $this->{$key} = $val;
            }
        }

    }

    public function urlParts($key = null)
    {
        $url = get_site_url();

        $url = parse_url($url);

        if (empty($url['path'])) {
            $url['path'] = '/';
        }

        if ($key) {
            return $url[$key];
        }

        return $url;
    }

    public function getJsonBody($array = false)
    {
        return json_decode(file_get_contents('php://input'), $array);
    }

    public function getArray()
    {
        $value = [];

        foreach ($_REQUEST as $key => $val) {
            $value[$key] = $val;
        }

        return $value;
    }

    /**
     * Enable calling protected and private properties
     */
    public function __get($key)
    {
        if (isset($this->{$key})) {
            return $this->{$key};
        }

        if ($key === 'post') {
            return $_POST;
        }

        if ($key === 'get') {
            return $_GET;
        }

        if ($key === 'request') {
            return $_REQUEST;
        }

        if (isset($this->_data[$key])) {
            return $this->_data[$key];
        }

        $upperKey = strtoupper($key);

        if (isset($_SERVER[$upperKey])) {
            return $_SERVER[$upperKey];
        }

    }

    public function getAuth($allowUrl = true)
    {
        if (!$this->_headers) {
            $this->loadHeaders();
        }

        $token = null;

        foreach ($this->_auth_header_keys as $key) {
            if (!empty($this->_headers[$key])) {
                $token = $this->_headers[$key];
                break;
            }
        }

        if (!$token && $allowUrl && !empty($this->auth_token)) {
            $token = $this->auth_token;
        }

        if (!$token) {
            return false;
        }

        if (strstr($token, ' ') === false) {
            return $token;
        }

        $n = strpos($token, ' ');
        $type = strtolower(substr($token, 0, $n));
        $token = substr($token, $n + 1);

        if (empty($token)) {
            return false;
        }

        if ($type === 'basic') {

            $token = base64_decode($token);

            if (strpos($token, ':') === false) {
                return false;
            }

            $i = explode(':', $token);

            return [
                'username' => array_shift($i),
                'password' => implode(':', $i),
            ];
        }

        return $token;

    }

    // BETA METHOD

    public function getAuthUser()
    {
        if ($this->auth_user) {
            return $this->auth_user;
        }

        $token = $this->getAuthToken();

        if ($token && strpos($token, '-') !== false) {
            $i = explode('-', $token);

            if (is_numeric($i[0])) {
                return get_user_by('id', $i[0]);
            }
        }

        return false;

    }
    public function getAuthToken($key = 'authorization')
    {
        $token = $this->getHeader($key);

        if (!$token) {

            if (empty($this->auth_token)) {
                return false;
            }

            $token = $this->auth_token;
        }

        $n = strpos($token, ' ');

        if ($n > 0) {
            return substr($token, $n + 1);
        }

        return $token;
    }

    public function getHeader($key, $na = false)
    {
        $key = $this->parseHeaderKey($key);

        if (!$this->_headers) {
            $this->loadHeaders();
        }

        // only return if has value
        return isset($this->_headers[$key]) && $this->_headers[$key] !== '' ? $this->_headers[$key] : $na;

    }

    private function loadHeaders()
    {
        $headers = getallheaders();
        foreach ($headers as $key => $val) {
            $key = $this->parseHeaderKey($key);
            $this->_headers[$key] = $val;
        }

    }

    private function parseHeaderKey($key)
    {
        return strtolower(str_replace('-', '_', $key));
    }

    public function has($key)
    {
        if (!is_array($key)) {
            $key = [$key];
        }

        foreach ($key as $k) {
            if (empty($this->{$k}) && empty($this->_data[$k])) {
                return false;
            }
        }

        return true;
    }

    public function get($key, $na = '')
    {
        if (!empty($this->_data[$key])) {
            return $this->_data[$key];
        }

        if (!empty($this->{$key})) {
            return $this->{$key};
        }

        return $na;
    }

    public function add($key, $data)
    {
        $this->_data[$key] = $data;
    }

    public function addParams($vars, $onlyNew = false)
    {
        foreach ($vars as $key => $val) {
            if (isset($this->{$key})) {

                if ($onlyNew) {
                    echo "\nEXISTS ";
                    continue;
                }

                $this->_replaced_params[$key] = $this->{$key};
            }
            $this->{$key} = $val;
        }
    }

    public function addNewParams($vars)
    {
        $this->addParams($vars, true);
    }

    // array or key value pair. Restores after added via addParams
    public function removeParams($vars, $restoreReplaced = false)
    {
        foreach ($vars as $key => $val) {

            // support arrays
            if (is_integer($key)) {
                $key = $val;
            }
            // remove
            if (isset($this->{$key})) {
                unset($this->{$key});
            }

            // restore param that was prevous: Used by route middlware
            if ($restoreReplaced && isset($this->_replaced_params[$key])) {
                $this->{$key} = $this->_replaced_params[$key];
                unset($this->_replaced_params[$key]);
            }
        }
    }

    public function setBaseUrl($url)
    {
        $this->_base_url = $url;
    }

    public function setCurrentUrl($url)
    {
        $this->_current_url = $url;
    }

    public function getBaseUrl($append = null)
    {
        // added v1.0.1
        if (function_exists('get_site_url')) {
            return get_site_url();
        }

        if (!isset($this->_base_url)) {
            $this->_base_url = $this->getHttp() . $this->getHost();
        }

        if ($append) {
            $append = '/' . ltrim($append, '/');
        }

        return $this->_base_url . $append;
    }

    public function getCurrentUrl()
    {
        if (!isset($this->_current_url)) {
            $this->_current_url = $this->getHttp() . $this->getHost() . $this->getUri();
        }

        return $this->_current_url;
    }

    public function getHttp($append = '://')
    {
        return $this->isSecure() ? 'https' . $append : 'http' . $append;
    }

    public function isSecure()
    {
        return isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';
    }

    public function getHost()
    {
        if (!isset($this->request_host)) {
            $this->request_host = $_SERVER['HTTP_HOST'];
        }

        return $this->request_host;
    }

    public function getUri()
    {
        if (!isset($this->request_uri)) {
            $this->request_uri = $_SERVER['REQUEST_URI'];
        }

        return $this->request_uri;
    }

    public function validate($arr)
    {
        if (is_string($arr)) {
            $arr = [$arr];
        }

        foreach ($arr as $i) {

            if (empty($this->{$i})) {
                return false;
            }

            if ($i === 'email' && !filter_var($this->{$i}, FILTER_VALIDATE_EMAIL)) {
                return false;
            }
        }

        return true;
    }

    public function only($arr)
    {
        $value = [];

        foreach ($arr as $i) {
            if (isset($this->{$i}) && $this->{$i} !== '') {
                $value[$i] = $this->{$i};
            }
        }

        return $value;
    }

}
