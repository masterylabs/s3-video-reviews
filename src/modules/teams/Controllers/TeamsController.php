<?php

namespace Masteryl\Modules\Teams\Controllers;

use Masteryl\Controller\Controller;

class TeamsController extends Controller
{
    public function adminApi($data)
    {
        $user = $this->app->user;

        if ($user->isAdmin()) {
            $data->config['teams_settings_fields'] = true;
        }

        if (!$this->isActive()) {
            return;
        }

        // contact
        $data->license->contact = $this->app->user->getContact();

        // addons
        $data->settings = $this->app->user->settings()->all();
    }

    public function settingsController($controller)
    {
        if (!$this->isUser() || !$this->isActive()) {
            return;
        }

        $controller->settings = $this->app->user->settings();

    }

    // ONLY CALLED IF ACTIVE

    public function collection($collection)
    {

        $model = $collection->getProp('model');

        if (!in_array('user_id', $model->fills)) {
            return;
        }

        $userId = $this->app->user->id;
        $collection->setProp('user_id', $userId);

    }

    private function isActive()
    {
        return $this->app->settings->meta('is_teams');
    }

    private function isUser()
    {
        $admin = $this->app->settings->meta('teams_admin');

        //  no admin, not yet setup
        if (!$admin) {
            return false;
        }

        $user = $this->app->user->user_login;

        return $admin !== $user;

    }

}
