<?php

namespace Masteryl\Oauth2\Traits;

trait Routes
{

    public function index($req, $res)
    {
        return $this->authorize($req, $res);
    }

    public function authorize($req, $res)
    {
        $this->req = $req;

        $this->res = $res;

        $meta = $req->only(['return_url', 'return_token']);

        $url = $this->getAuthorizationUrl($meta);

        // ee($url);

        return $res->redirect($url);

    }

    public function callback($req, $res)
    {
        $this->req = $req;

        $this->res = $res;

        ee('callback', $req);

        // validate state
        if (!$req->has('state') || !$this->validateState($req->state)) {
            return $res->invalid('Invalid or missing state');
        }

        // exchange code for access token TEAST
        // return $this->onCallbackDone();

        $params = [
            'code' => $req->code,
            'grant_type' => 'authorization_code',
            'redirect_uri' => $this->getRedirectUri(),
        ];

        $json = $this->request('token', $params);

        if (is_object($json) && !empty($json->access_token) && method_exists($this, 'setToken')) {
            $this->setToken($json);
        }

        // potencial return url
        return $this->onCallbackDone();

    }

    public function onCallbackDone()
    {
        if (!empty($this->state_values->meta)) {

            $meta = $this->state_values->meta;

            if (!empty($meta->return_url)) {
                $this->res->redirect($meta->return_url);
                // ee('onCallbackDone', $meta->return_url);

            }
        }

    }
}
