<?php

namespace Masteryl\Modules\Settings;

// extendable

class Controller
{
    // protected $req;

    // protected $res;

    public $settings;

    public function __construct($req, $res, $settings = null)
    {
        // $this->req = $req;

        // $this->res = $res;

        if ($settings) {
            $this->settings = $settings;
        } else {
            $this->settings = $req->app->settings;
        }

        // enable teams
        $req->app->call('settings.controller', $this);
    }

    /**
     * No further changes for extension
     */

    public function index($req, $res)
    {
        return $res->data($this->settings->all());
    }

    public function update($req, $res)
    {
        $this->settings->update($req);

        return $res->message('Updated');
    }

    public function destroy($req, $res)
    {
        $this->settings->destroy();

        return $res->message('Deleted');
    }

}
