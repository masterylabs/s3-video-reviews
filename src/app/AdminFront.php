<?php

namespace S3VideoReviews;

use Masteryl\Controller\Controller;
use Masteryl\Helpers\Vue;

class AdminFront extends Controller
{
    public function __invoke($req, $res)
    {
        $app = $req->app;
        $vue = new Vue($app, 'client/index');
        $vue->api()->auth($app->userAuth);

        if ($app->brand && $app->brand->isActive() && $app->brand->primary_color) {
            $vue->data('primary_color', $app->brand->primary_color);
            $vue->data('secondary_color', $app->brand->secondary_color);
            $vue->data('accent_color', $app->brand->accent_color);
        }

        $vue->useVersion();

        $vue->render();
        exit;

    }
}
