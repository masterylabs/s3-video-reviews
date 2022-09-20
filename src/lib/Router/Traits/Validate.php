<?php

namespace Masteryl\Router\Traits;

use Masteryl\Helpers\Str;
use Masteryl\Request\Request;

trait Validate
{
    public function validateRoute($route)
    {
        $req = $this->getRequest();

        $rm = $req->request_method;

        // method

        if (!in_array($rm, $route->request_methods)) {
            return false;
        }

        // path

        if (!$this->validateRoutePath($route)) {
            return false;
        }

        // middlware

        if (!$this->validateRouteMiddleware($route)) {
            return false;
        }

        // valid route, add params
        if ($route->params) {
            $req->addParams($route->params);
        }

        return true;

    }

    private function validateRouteMiddleware($route)
    {

        $middleware = $route->middleware;

        if (!$middleware) {
            return true;
        }

        if (is_string($middleware)) {
            $middleware = [$middleware];
        }

        // get params from previous request

        $res = $this->app->response;
        $req = new Request($this->app);

        if ($route->params) {
            $req->addParams($route->params);
        }

        foreach ($middleware as $mw) {

            if (empty($mw)) {
                continue;
            }

            $class = new $mw($req, $res);

            $req = $class->handle($req, $res);

            if (!$req) {
                return false;
            }

        }

        $this->setRequest($req);

        return true;

    }

    private function validateRoutePath($route)
    {
        $req = $this->getRequest();

        $reqDirs = $this->getPathArray($req->request_path);

        $routeDirs = $this->getPathArray($route->path);

        // ee('validatePath');

        if (count($reqDirs) !== count($routeDirs) && strpos($route->path, '**') === false) {
            return false;
        }

        foreach ($routeDirs as $i => $dir) {

            $val = $reqDirs[$i];

            // wildcard path

            if ($dir === '**') {
                return true;
            }

            // wildcard dir

            if ($dir === '*') {
                continue;
            }

            // wildcard start

            if (strpos($dir, '*') === 0) {
                $end = ltrim($dir, '*');
                if (Str::endsWith($val, $end)) {
                    continue;
                }
                return false;
            }

            // wildcard end

            if (Str::endsWith($dir, '*')) {
                $start = rtrim($dir, '*');

                if (strpos($val, $start) === 0) {
                    continue;
                }

                return false;
            }

            // center wild card

            if (strpos($dir, '*') !== false) {

                $a = explode('*', $dir);

                if (strpos($val, $a[0]) !== 0 || !Str::endsWith($val, $a[1])) {
                    return false;
                }

                continue;
            }

            if (strpos($dir, '{') === 0) {

                $key = trim($dir, '{}');

                $route->addParam($key, $val);

                continue;

            }

            // exact match

            if ($dir !== $val) {
                return false;
            }
        }

        return true;
    }
}
