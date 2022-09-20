<?php

namespace Masteryl\Modules\Login;

use S3VideoReviews\AdminApi;

class Login
{
    protected $app;

    public function __construct($app)
    {
        $this->app = $app;

    }
    public function unauthorized()
    {
        $api = new AdminApi($this->app);
        $req = $this->app->request;
        $res = $this->app->response;

        return $api->unauthenticated($req, $res);

    }

    public function adminApi($api)
    {
        // enable cors
        $this->app->router->allowCors();
        $api->config['use_login'] = true;
    }

    /**
     * Login
     */

    public function login($req, $res)
    {
        $user = get_user_by('login', $req->login);
        if (!$user || !wp_check_password($req->password, $user->data->user_pass, $user->ID)) {
            return $res->unauthorized();
        }

        $token = $req->app->userAuth->setUser($user->ID)->getAccessToken();

        return $res->json(compact('token'));
    }
}
