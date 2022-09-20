<?php

namespace Masteryl\Modules\Client\Middleware;

use Masteryl\Modules\Client\Host;

class HostMiddleware
{
    public function handle($req, $res)
    {
        $token = $req->getAuthToken();

        if (!$token) {
            return $res->unauthorized();
        }

        // validate token
        $host = new Host($req->app, $token);

        if (!$host->handshake($token)) {
            // something went wrong
            return $res->json($host->response->body, $host->response->code);

        }

        // all good

        $req->host = $host;

        return $req;

    }
}
