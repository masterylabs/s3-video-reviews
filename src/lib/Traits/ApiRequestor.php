<?php

namespace Masteryl\Traits;

use Masteryl\Helpers\Url;
use Masteryl\Remote\Remote;

trait ApiRequestor
{
    // protected $api_url;

    // protected $endpoint;

    // protected $query_params = [];

    public function requestBody($method = 'GET', $endpoint = '', $body = null)
    {
        return $this->request($method, $endpoint, $body, true);
    }

    public function onFailedRequest($res)
    {
        if ($this->auth && is_object($this->auth) && method_exists($this->auth, 'refreshToken')) {
            ee('refresh token');
        }
    }

    public function requestorMaybeRefreshAuth()
    {
        if (!empty($this->auth_refreshed)) {
            return false;
        }

        if (empty($this->auth) || !is_object($this->auth) || !method_exists($this->auth, 'refreshToken')) {
            return false;
        }

        $this->auth->refreshToken();

        $this->auth_refreshed = true;

        return true;
    }

    public function request($method = 'GET', $endpoint = '', $body = null, $returnResponse = false)
    {
        $url = $this->api_url;

        if (!empty($this->endpoint)) {
            $url .= '/' . $this->endpoint;
        }

        if (!empty($endpoint)) {
            $url .= '/' . ltrim($endpoint, '/');
        }

        if (!empty($this->query_params)) {
            $url = Url::append($url, $this->query_params);
        }

        $args = [
            'method' => $method,
            'headers' => $this->getRequestHeaders(),
            // 'body' => $body,
        ];

        if (!empty($body)) {
            $args['body'] = $body;
        }

        // ee($url, $args);

        $res = Remote::request($url, $args)->getJson();

        // auto-refresh expired (sometimes expired even if within given time)

        if ($res->code >= 300) {
            ee('refresh');
            $refreshed = $this->requestorMaybeRefreshAuth();
            if ($refreshed) {
                return $this->request($method, $endpoint, $body, $returnResponse);
            }
        }

        $this->response_body = $res->body;

        $this->response_code = $res->code;

        if ($returnResponse) {
            return $res;
        }

        if (method_exists($this, 'responseHandler')) {
            $this->responseHandler($res);
        }

        return $this;
    }

    public function getRequestHeaders()
    {
        return [
            'Authorization' => 'Bearer ' . $this->api_key,
            'Accept' => 'application/json',
        ];
    }

    public function requestError()
    {
        return empty($this->response_code) || $this->response_code >= 300;
    }
}
