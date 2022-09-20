<?php

namespace Masteryl\App\Traits;

use Masteryl\Helpers\Str;

trait Getters
{

    public function isSuperAdmin()
    {
        $user = $this->getUser();

        if (!$user) {
            return false;
        }

        $admins = get_super_admins();

        return in_array($user->user_login, $admins);
    }

    public function getUser()
    {

        if ($this->user) {
            return $this->user;
        }

        if ($this->request && $this->request->auth_user) {
            $this->user = $this->request->auth_user;
            return $this->user;
        }

        $loggedIn = get_current_user_ID();

        if ($loggedIn > 0) {

            $this->user = get_user_by('id', $loggedIn);
            return $this->user;
        }

        // temp
        if ($this->request) {
            return $this->request->getAuthUser();
        }

        return false;
    }

    public function getModuleNamespace($name, $append = '')
    {
        return 'Masteryl\\Modules\\' . Str::toCamel($name, true) . $append;
    }

    // used by integrations including updates
    public function getPluginFileName()
    {
        $i = explode('/', $this->plugin_file);
        $file = array_pop($i);
        return end($i) . '/' . $file;
    }

    public function getPluginUrl($append = '')
    {
        $key = $this->plugin_namespace . '_plugin_url';

        if (defined($key)) {
            $this->plugin_url = constant($key);
        }

        if (isset($this->plugin_url)) {
            return $this->plugin_url . $append;
        }

        return plugin_dir_url($this->plugin_file) . $append;
    }

    public function getPath($append = '')
    {
        return $this->plugin_dir . '/' . $append;
    }

    public function getUrl($append = '', $appendPrefix = false)
    {
        if (!$this->request) {
            $this->load_request();
        }

        if (isset($this->url)) {
            $url = $this->url;
        } else {
            $url = $this->request->getBaseUrl();
        }

        if (!empty($append)) {
            $append = '/' . ltrim($append, '/');
        }

        return $url . $append;
    }

    public function beforeBrand()
    {
        $this->is_branded = true;

        $this->unbranded = [
            'slug' => $this->slug,
            'id' => $this->id,
            'name' => $this->name,
        ];

        // ee($this->unbranded);
    }

    public function getAppUrl($append = '')
    {
        if (!empty($append)) {
            $append = '/' . ltrim($append, '/');
        }

        $slug = $this->slug;

        if ($this->is_branded) {
            $slug = $this->unbranded['slug'];
        }

        // ee($slug);
        return $this->getUrl($slug) . $append;

        // return

    }
}
