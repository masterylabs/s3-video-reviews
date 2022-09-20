<?php

namespace Masteryl\Modules\Client\Controllers;

class HostController
{

    public function lookup($req, $res)
    {
        $data = [
            'license' => $req->host->getLicense(),
            'install_key' => $req->host->install_key,
        ];

        return $res->json($data);

        ee('HostController: updateLicense', $req);
    }

    public function deactivate($req, $res)
    {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';

        $plugin = $req->app->getPluginFileName();

        \deactivate_plugins($plugin);

        return $res->ok();
    }

    public function process($req, $res)
    {

        $app = $req->app;
        $body = $req->getJsonBody();

        if (!empty($body->update_options)) {
            foreach ($body->update_options as $key => $val) {
                $app->option($key)->update($val);
            }
        }

        if (!empty($body->delete_options)) {
            foreach ($body->delete_options as $key) {
                $app->option($key)->destroy();
            }
        }

        return $res->ok();
    }
}
