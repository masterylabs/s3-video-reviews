<?php

namespace Masteryl\Router\Traits;

trait Redirect
{
    public function redirect($path, $url, $code = 301, $args = [], $rm = 'get')
    {
        $args['redirect_url'] = $url;
        $args['redirect_code'] = $code;

        return $this->_createRoute($rm, $path, null, $args);
    }

    public function redirectPost($path, $url, $code = 301, $args = [])
    {
        return $this->redirect($path, $url, $code, $args, 'post');
    }

    private function callRedirectRoute($route)
    {

        $params = $route->getParams();

        $res = $this->getResponse();

        $url = $route->redirect_url;
        $code = $route->redirect_code;

        return $res->redirect($url, $code, $params);

    }
}
