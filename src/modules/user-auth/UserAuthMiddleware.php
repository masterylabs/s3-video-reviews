<?php

namespace Masteryl\Modules\UserAuth;

class UserAuthMiddleware
{

    public function handle($req, $res)
    {
        $app = $req->app;

        $auth = $app->userAuth;

        $token = $req->getAuthToken();

        // ee('token', $token);

        if (!$token || !$auth->validateToken($token)) {
            $app->call('userAuth.unauthorized', [$req, $res]);
            return $res->allowCors()->unauthorized();
        }

        $req->add('auth_user', $auth->user_id);

        return $req;

    }

}
