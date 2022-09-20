<?php

namespace Masteryl\Modules\User;

use Masteryl\Modules\User\UserSettings;

class User
{
    protected $app;

    private $user;

    private $_settings;

    public function __construct($app, $id = null)
    {
        $this->app = $app;

        if ($id) {
            $this->id = $id;
        }

        // get from userAuth
        elseif (!$this->id && $app->userAuth && $app->userAuth->user_id) {
            $this->id = $app->userAuth->user_id;
        } else {
            $this->id = get_current_user_id();
        }

        if ($this->id) {
            // load user by id
            $this->user = get_user_by('id', $this->id);
        }
    }

    public function __get($key)
    {
        if ($this->user) {
            if (isset($this->user->{$key})) {
                return $this->user->{$key};
            }

            if (isset($this->user->data->{$key})) {
                return $this->user->data->{$key};
            }

            $dataKey = 'user_' . $key;
            if (isset($this->user->data->{$dataKey})) {
                return $this->user->data->{$dataKey};
            }
        }
    }

    public function getContact()
    {
        $contact = (object) [];
        $contact->first_name = $this->user->data->display_name;
        $contact->last_name = '';
        $contact->avatar = md5($this->user->data->user_email);
        return $contact;
    }

    public function isAdmin()
    {
        return !empty($this->user->caps['administrator']);
    }

    // App Settings
    public function settings()
    {
        if (!isset($this->_settings)) {
            $this->loadSettings();
        }

        return $this->_settings;
    }

    private function loadSettings()
    {
        $options = $this->app->userOptions('settings');

        $this->_settings = new UserSettings($this->app, $options, 'settings', ['user_id' => $this->id]);

    }

}
