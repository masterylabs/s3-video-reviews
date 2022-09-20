<?php
/**
 * verison 3
 */

namespace Masteryl\Router;

use Masteryl\Router\Route;
use Masteryl\Router\Traits\Api;
use Masteryl\Router\Traits\Call;
use Masteryl\Router\Traits\Collection;
use Masteryl\Router\Traits\Getters;
use Masteryl\Router\Traits\Helpers;
use Masteryl\Router\Traits\Redirect;
use Masteryl\Router\Traits\Setters;
use Masteryl\Router\Traits\Validate;

class Router
{
    /**
     * Miracle properties you can call
     *
     * request
     * response
     * db
     */
    use Api, Call, Collection, Getters, Helpers, Redirect, Setters, Validate;

    protected $prefix;

    private $routes = [];

    private $app;

    private $groups = [];

    private $route_methods = [
        'get' => 'get',
        'post' => 'post',
        'put' => 'post',
        'patch' => 'patch',
        'delete' => 'delete',
        'options' => 'options',
        // match,
        'any' => ['get', 'post', 'put', 'patch', 'delete', 'options'],
    ];

    private $request;

    private $response;

    private $is_root = false;

    public function __construct($app)
    {
        $this->app = $app;

        if ($app->url_prefix) {
            $this->prefix = $app->url_prefix;
        }
        // ee($app->slug);

        // ee(['prefix', $this->prefix]);

        // ee('Router', $this->app->namespace);
    }

    public function getRoutes()
    {
        return $this->routes;
    }

    public function root($value = true)
    {
        $this->is_root = $value;
        return $this;
    }

    public function __call($key, $args = [])
    {
        if (isset($this->route_methods[$key])) {
            // ee('create route', [$key, $args]);
            return $this->_createRoute($key, ...$args);
        }
        if ($key === 'match') {
            return $this->_createRoute(...$args);
        }
    }

    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
        // ee('setPrefix', $this->prefix);
    }

    public function api($args, $cb = null)
    {
        if (is_null($cb)) {
            $cb = $args;
            $args = [
                'path' => '/api',
                'api' => true,
            ];
        } else {
            $args['api'] = true;
            if (!isset($args['path'])) {
                $args['path'] = '/api';
            }
        }

        if (strpos($args['path'], '/api') !== 0) {
            $args['path'] = '/api/' . ltrim($args['path'], '/');
        }

        return $this->group($args, $cb);
    }

    public function group($args, $cb)
    {
        if (is_string($args)) {
            $args = [
                'path' => $args,
            ];
        }

        $this->groups[] = $this->parseArgs($args);

        // if ($args['path'] !== '/api') {
        //     ee($args);
        // }

        call_user_func($cb, $this);

        array_pop($this->groups);

        // ee('group: ' . $index, $args);
    }

    private function parseArgs($args)
    {

        if (isset($args['middleware']) && is_string($args['middleware'])) {
            $args['middleware'] = [$args['middleware']];
        }
        return $args;
    }

    public function embedView($path, $view, $params = [], $args = [])
    {
        $args['embed_view'] = true;
        return $this->view($path, $view, $params, $args);
    }

    public function embedPostView($path, $view, $params = [], $args = [])
    {
        $args['embed_view'] = true;
        return $this->view($path, $view, $params, $args, 'post');
    }

    public function postView($path, $view, $params = [], $args = [])
    {
        return $this->view($path, $view, $params, $args, 'post');
    }

    public function view($path, $view, $params = [], $args = [], $rm = 'get')
    {
        $args['view'] = $view;
        $args['view_params'] = $params;
        return $this->_createRoute($rm, $path, null, $args);
    }

    private function _createRoute($rm, $path = '', $cb = null, $args = [])
    {

        $methods = $this->route_methods[$rm];

        // BETA TESTING
        if (is_string($cb) && strpos($cb, '\\') === false) {
            $cb = $this->namespaceCallback($cb);
        }

        // convert string to middlware

        if (is_string($args)) {
            $args = [
                'middleware' => $args,
            ];
        }

        if ($this->is_root) {
            $args['root'] = true;
        }

        $args = $this->parseArgs($args);

        if ($this->groups) {
            $path = $this->getGroupPath($path);
            $args = $this->getGroupArgs($args);
        }

        $route = Route::create($methods, $path, $cb, $args);

        if ($this->prefix && empty($args['root']) && !$this->isFirstGroupRoot()) {
            $route->addPrefix($this->prefix);
        }

        if (!empty($args['api']) || $this->isFirstGroupApi()) {
            $route->setApi(true);
        }

        $this->routes[] = $route;

        return $route;
    }

    private function isFirstGroupApi()
    {
        if (!$this->groups || empty($this->groups[0]['api'])) {
            return false;
        }

        return true;

    }

    private function isFirstGroupRoot()
    {
        if (!$this->groups || empty($this->groups[0]['root'])) {
            return false;
        }

        return true;

    }

    private function getGroupArgs($args = [])
    {
        $mw = [];

        foreach ($this->groups as $group) {

            // middleware
            if (!empty($group['middleware'])) {
                $mw = array_merge($mw, $group['middleware']);

            }
        }
        // ee($args);

        if (!isset($args['middleware'])) {
            $args['middleware'] = $mw;
        } else {
            $args['middleware'] = array_merge($mw, $args['middleware']);
        }

        return $args;
    }

    private function getGroupPath($append)
    {
        $path = '';

        foreach ($this->groups as $group) {
            if (!empty($group['path'])) {
                $path .= '/' . trim($group['path'], '/');
            }
        }

        $append = trim($append, '/');

        if (!empty($append)) {
            $path .= '/' . $append;
        }

        return $path;
    }

}
