<?php

namespace Masteryl\Router\Traits;

trait Call
{

    public function callRoutes()
    {

        foreach ($this->routes as $route) {

            if ($this->validateRoute($route)) {
                $this->callRoute($route);
            }

        }
    }

    public function callValidRoute()
    {
        foreach ($this->routes as $route) {

            if ($this->validateRoute($route)) {
                return $this->callRoute($route);
            }
        }

        return false;
    }

    /**
     * Primary Route Caller
     */

    public function callRoute($route)
    {
        if (is_string($route)) {
            $route = $this->getRouteByName($route);
        }

        if ($route->isView()) {
            return $this->callViewRoute($route);
        }

        if ($route->isRedirect()) {
            return $this->callRedirectRoute($route);
        }

        $req = $this->getRequest();

        $res = $this->getResponse();

        if ($route->is_api) {
            $this->allowCors();
        }

        // already added
        // if ($route->params) {
        //     $req->addParams($route->params);
        // }

        $cb = $route->callback;

        if (is_object($cb)) {
            $cbRes = call_user_func($cb, $req, $res);

        } else {

            if (is_string($cb) && strstr($cb, '@') == true) {
                $cb = explode('@', $cb);
            }

            if (is_array($cb)) {
                $class = new $cb[0]($req, $res);
                $cbRes = $class->{$cb[1]}($req, $res);
            } else {
                $class = new $cb($req, $res);
                $cbRes = $class($req, $res);
            }

        }

        if (is_string($cbRes)) {
            echo $cbRes;
        }

        if (!is_null($cbRes)) {
            exit;

        }

    }

    /**
     * Private Callers
     */

    private function callViewRoute($route)
    {
        $params = $route->getParams();

        $res = $this->getResponse();

        if ($route->embed_view) {
            return $res->embedView($route->view, $params);
        }

        return $res->view($route->view, $params);

    }
}
