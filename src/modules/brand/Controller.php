<?php

namespace Masteryl\Modules\Brand;

use Masteryl\Helpers\WPGetter;

class Controller
{
    public function __construct($req, $res)
    {
        $this->req = $req;
    }

    public function __invoke($req, $res)
    {
        $app = $req->app;

        $brand = $app->brand;

        $fields = $brand->getOption('fields');

        $addons = $app->license->getAddons();

        $addons = $brand->filterAddons($addons);

        $settings = $brand->settings()->all();

        $roles = WPGetter::roles();

        $unbraded = $brand->unbraded;

        return $res->data(compact('unbraded', 'fields', 'settings', 'addons', 'roles'));
    }

}
