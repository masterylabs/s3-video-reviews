<?php

namespace Masteryl\Router\Traits;

trait Getters
{
    /**
     * Private Getters
     */
    public function getRouteUrl($routeName = null)
    {
        // ee('getRouteUrl', [$routeName, $this->routes]);

        foreach ($this->routes as $route) {
            if (isset($route->name) && $route->name === $routeName) {
                return $this->app->getUrl($route->path);
            }
        }

        return false;
    }

    private function getRequest()
    {
        if (!isset($this->request)) {
            $this->request = $this->app->request;
        }
        return $this->request;
    }

    private function getResponse()
    {
        if (!isset($this->response)) {
            $this->response = $this->app->response;
        }
        return $this->response;
    }

    public function getRouteByName($name)
    {
        foreach ($this->routes as $route) {
            if (isset($route->name) && $route->name === $name) {
                return $route;
            }
        }
        return false;
    }

    /**
     * Helper Getters
     */

    private function getPathArray($path)
    {
        return strlen($path) > 1 ? explode('/', trim($path, '/')) : [];
    }

}
