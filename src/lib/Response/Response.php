<?php

namespace Masteryl\Response;

use Masteryl\Template\Template;
use Masteryl\Template\Vue;

class Response
{
    protected $app;

    public function __construct($app = null)
    {
        $this->app = $app;
    }

    public function allowCors($val = '*')
    {
        header("Access-Control-Allow-Origin: " . $val);
        header("Access-Control-Allow-Headers: " . $val);
        header("Access-Control-Allow-Methods: " . $val);
        return $this;
    }

    public function embedVue($file, $view = null, $vars = [])
    {
        return $this->vue($file, $view, $vars, false);
    }

    public function vue($file, $view = null, $vars = [], $end = true)
    {
        $vue = new Vue($this->app, $file);

        if ($view) {
            $vars['vueScripts'] = $vue->getHeaderScripts();

            $this->view($view, $vars, $end);
        } else {
            $vue->render();
            if ($end) {
                exit;
            }

        }

    }

    public function js()
    {
        header('Content-Type: application/javascript');
        return $this;
    }

    public function getView($view, $vars = [])
    {
        return $this->view($view, $vars, false, true);
    }

    public function view($view, $vars = [], $end = true, $getView = false)
    {
        $template = new Template($this->app);

        $code = $template->getView($view, $vars);

        if ($getView) {
            return $code;
        }

        // expose vars
        foreach ($vars as $key => $val) {
            $$key = $val;
        }

        eval('?>' . $code);

        if ($end) {
            exit;
        }
    }

    public function embedView($view, $args = [])
    {
        return $this->view($view, $args, false);
    }

    public function ok($code = 200)
    {
        http_response_code($code);
        header('Content-Type: application/json; charset=utf-8');
        exit;
    }

    public function success($message = false, $code = 200)
    {
        http_response_code($code);
        header('Content-Type: application/json; charset=utf-8');

        $data = [
            'success' => true,
        ];

        if ($message) {
            $data['message'] = $message;
        }

        echo json_encode($data);
        exit;
    }

    public function badRequest($message = 'Bad Request')
    {
        return $this->message('Bad Request', 400);
    }

    public function redirect($url, $code = 302, $params = null)
    {
        if ($params) {
            $url = $this->appendUrlParams($url, $params);
        }
        wp_redirect($url, $code);
        exit;
    }

    private function appendUrlParams($url, $params)
    {
        $url .= strpos($url, '?') === false ? '?' : '&';

        foreach ($params as $key => $val) {
            $url .= $key . '=' . urlencode($val) . '&';
        }

        return rtrim($url, '&');
    }

    public function json($data = [], $code = 200)
    {
        http_response_code($code);

        header('Content-Type: application/json; charset=utf-8');

        if ($data && !is_string($data)) {
            $data = json_encode($data);
        }

        if (!empty($data)) {
            echo $data;
        }
        exit;
    }

    public function data($data, $code = 200)
    {
        return $this->json(['data' => $data], $code);
    }

    /**
     * Mesage
     */

    public function message($message, $code = 200)
    {
        return $this->json(['message' => $message], $code);
    }

    public function invalid($message = 'Invalid')
    {
        return $this->message($message, 400);
    }

    public function error($message = 'Invalid')
    {
        return $this->message($message, 400);
    }

    public function unauthorized($msg = 'Unauthorized')
    {
        return $this->message($msg, 401);
    }

    public function notFound($message = 'Not Found')
    {
        return $this->message($message, 404);
    }

    public function notAllowed($message = 'Not Allowed')
    {
        return $this->message($message, 405);
    }

    public function forbidden($msg = 'Forbidden')
    {
        return $this->message($msg, 403);
    }

    public function response($api)
    {
        return $this->json($api->body, $api->code);
    }

    public function jsonView($view)
    {
        header('Content-Type: application/json; charset=utf-8');
        $path = $this->app->getPath('views/' . str_replace('.', '/', $view) . '.json');
        if (file_exists($path)) {
            $data = file_get_contents($path);
            echo $data;
        }
        exit;
    }

}
