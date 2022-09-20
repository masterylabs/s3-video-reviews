<?php

namespace Masteryl\Modules\Client\Controllers;

use Masteryl\Modules\Client\Client;

class LicenseController
{

    public function update($req, $res)
    {

        if (!$req->validate(['email', 'password'])) {
            return $res->invalid('Valid email and password required');
        }

        $client = new Client($req->app);

        $host = $client->updateLicense($req->email, $req->password);

        return $res->json($host->body, $host->code);
    }

    public function destroy($req, $res)
    {
        if (!$req->validate(['email', 'password'])) {
            return $res->invalid('Valid email and password required');
        }

        $client = new Client($req->app);

        $host = $client->deleteLicense($req->email, $req->password);

        return $res->json($host->body, $host->code);
    }
}
