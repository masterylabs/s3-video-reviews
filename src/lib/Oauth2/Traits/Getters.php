<?php

namespace Masteryl\Oauth2\Traits;

use Masteryl\Helpers\Url;

trait Getters
{
    public function getClientId()
    {
        return $this->client_id;
    }

    public function getClientSecret()
    {
        return $this->client_secret;
    }

    public function getRefreshToken()
    {
        $token = $this->getToken();

        return $token && !empty($token->refresh_token) ? $token->refresh_token : false;

    }

    public function getState($meta = [])
    {
        $data = [
            'name' => get_bloginfo('name'),
            'url' => get_bloginfo('url'),
            'created' => current_time('U'),
        ];

        if (!empty($meta)) {
            $data['meta'] = $meta;
        }

        return base64_encode(json_encode($data));
    }

    public function getRedirectUri()
    {
        if (!$this->redirect_uri) {
            ee('no arequest uri');
        }

        if (strpos($this->redirect_uri, '://') > 0) {
            return $this->redirect_uri;
        }

        return $this->req->app->router->getRouteUrl($this->redirect_uri);
    }

    public function getScopes()
    {
        if (empty($this->scopes)) {
            return '';
        }

        if (is_string($this->scopes)) {
            return $this->scopes;
        }

        return implode(' ', $this->scopes);
    }

    public function getAuthorizationUrl($stateMeta = [])
    {
        // build auth url
        $url = $this->url . '/authorize';

        $scopeKey = $this->scope_key;

        $params = [
            'response_type' => $this->response_type,
            'client_id' => $this->getClientId(),
            'redirect_uri' => $this->getRedirectUri(),
            $scopeKey => $this->getScopes(),
            'state' => $this->getState($stateMeta),
        ];

        if ($this->authorize_params) {
            $params = array_merge($params, $this->authorize_params);
        }

        return Url::append($url, $params);
    }

    /**
     * Privates
     */

    private function getDebugData()
    {
        $i = explode('.', $this->redirect_uri);
        $name = $i[1];
        // ee($name);
        $obj = (object) [];
        $obj->body = json_decode(file_get_contents(__DIR__ . '/../_' . $name . '-token.json'));
        $obj->code = 200;

        return $obj;
    }
}
