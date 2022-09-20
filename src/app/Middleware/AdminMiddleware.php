<?php

namespace S3VideoReviews\Middleware;

class AdminMiddleware
{
    public function handle($req, $res)
    {
        $app = $req->app;

        $auth = $app->userAuth;

        $token = $req->getAuthToken();

        if (!$token || !$auth->validateToken($token)) {
            return false;
        }

        $req->add('auth_user', $auth->user_id);

        return $req;

    }
}
