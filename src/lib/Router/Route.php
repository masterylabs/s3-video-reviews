<?php
/**
 * verison 3
 */

namespace Masteryl\Router;

class Route
{
    public $path = '';

    public $name;

    protected $request_methods = [];

    // protected $is_resource;

    protected $callback;

    protected $args = [];

    protected $view;

    protected $redirect_url;

    protected $redirect_code;

    protected $params = [];

    protected $is_api = false;

    public static function __callStatic($m, $args = [])
    {
        $m = '_' . $m;
        return (new static )->{$m}(...$args);
    }

    /**
     * Enable calling protected and private properties
     */
    public function __get($key)
    {
        if (isset($this->{$key})) {
            return $this->{$key};
        }

        if (isset($this->args[$key])) {
            return $this->args[$key];
        }

        return null;
    }

    /**
     * Is
     */

    public function isView()
    {
        return !empty($this->args['view']);
    }

    public function isRedirect()
    {
        return !empty($this->args['redirect_url']);
    }

    /**
     * Adders
     */

    public function addParams($params)
    {
        foreach ($params as $key => $val) {
            $this->addParam($key, $val);
        }

        return $this;
    }

    public function addPrefix($prefix)
    {
        $this->path = "/{$prefix}/" . ltrim($this->path, '/');
    }

    public function addParam($key, $val)
    {
        $this->params[$key] = $val;

        return $this;
    }

    /**
     * Setters
     */

    public function setApi($value = true)
    {
        $this->is_api = $value;
    }

    public function name($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Getters
     */

    public function getMiddleware()
    {
        if (!empty($this->args) && !empty($this->args['middleware'])) {
            return $this->args['middleware'];
        }
        return false;
    }

    public function getParams()
    {

        if ($this->isView() && !empty($this->args['view_params'])) {
            return array_merge($this->args['view_params'], $this->params);
        }

        return $this->params;
    }

    /**
     * Methods
     */

    public function _create($rm, $path = '', $cb = null, $args = [])
    {
        if (!is_array($rm)) {
            $rm = [$rm];
        }

        $this->request_methods = $rm;

        $this->path = '/' . trim($path, '/');

        $this->callback = $cb;

        $this->args = $args;

        return $this;

    }

    public function _view($rm, $path = '', $args = [])
    {
        $this->view = $view;
        return $this->_create($rm, $path, null, $args);
    }

}
