<?php

namespace Masteryl\Modules\Brand;

use Masteryl\Helpers\Fields;
use Masteryl\Helpers\WPUser;
use Masteryl\Modules\Settings\Settings;

class Brand
{

    protected $app;

    protected $options;

    protected $is_active;

    protected $orig;

    private $_settings;

    protected $unbraded;

    public function __construct($app, $options, $setbrand = false)
    {
        $this->app = $app;

        $this->options = $options;

        $this->unbraded = [];

        $this->setUnbranded();

        add_filter('all_plugins', [$this, 'onAllPlugins'], 10, 1);

        if ($setbrand && $this->isActive()) {
            $this->setBrand();
        }

    }

    public function __get($key)
    {
        if (isset($this->{$key})) {
            return $this->{$key};
        }

        return $this->settings()->{$key};
    }

    public function getColors()
    {
        $items = $this->options['fields']['colors'];

        $value = [];

        foreach ($items as $item) {
            $key = $item['value'];
            $shortKey = substr($key, 0, -6);
            $value[$shortKey] = $this->{$key};
        }

        return $value;
    }

    /**
     * Events
     */

    public function onAllPlugins($items)
    {

        // not active or not enabled
        $sett = $this->settings();

        if (!$sett->is_active || !$sett->hide_plugin) {
            return $items;
        }

        if ($this->isAdmin()) {
            return $items;
        }

        $name = $this->app->getPluginFileName();

        return array_filter($items, function ($key) use ($name) {
            return $key !== $name;
        }, ARRAY_FILTER_USE_KEY);

    }

    /**
     * Validations
     */
    public function getAddons()
    {
        return $this->settings()->addons;
    }

    public function isClient()
    {
        return $this->isActive() && $this->isUser();
    }

    public function isActive()
    {
        if (!isset($this->is_active)) {
            $this->is_active = $this->settings()->is_active;
        }
        return $this->is_active;
    }

    public function isAdmin($user = null)
    {
        $app = $this->app;

        if ($app->isSuperAdmin()) {
            return true;
        }

        $user = $app->getUser();

        if (!$user) {
            return false;
        }

        $roles = $this->getSetting('admin_roles');

        if (empty($roles) && WPUser::isAdmin($user)) {
            return is_super_admin($user->ID);
        }

        return WPUser::hasRole($user, $roles);
    }

    public function isUser()
    {
        if ($this->isAdmin()) {
            return false;
        }

        $user = $this->app->getUser();

        $roles = $this->getSetting('user_roles');

        if (empty($roles) && WPUser::isAdmin($user)) {
            return true;
        }

        return WPUser::hasRole($user, $roles);
    }

    public function userHasAccess($user)
    {
        return $this->isAdmin() || $this->isUser();

    }

    /**
     * Setters
     */

    private function setUnbranded()
    {
        $app = $this->app;

        $props = $this->options['unbranded'];

        $value = [];

        if (isset($props['app'])) {
            $value['app'] = [];
            foreach ($props['app'] as $key) {
                $value['app'][$key] = $app->{$key};
            }
        }

        $this->unbraded = $value;
    }

    /**
     * Validations
     */

    /**
     * Geters
     */

    public function getUserRoles()
    {
        return $this->getSetting('user_roles');
    }

    public function getAdminRoles()
    {
        return $this->getSetting('admin_roles');
    }

    public function getSetting($key, $na = null)
    {
        $value = $this->settings()->{$key};
        return !is_null($value) ? $value : $na;
    }

    /**
     * Setters
     */

    public function setBrand()
    {
        $app = $this->app;

        if (method_exists($app, 'beforeBrand')) {
            $app->beforeBrand();
        }

        $s = $this->settings();

        $keys = $this->getBrandKeys();

        foreach ($keys as $key) {
            if (!is_null($s->{$key}) && $s->{$key} !== '') {

                $this->app->setProp($key, $s->{$key});
            }
        }

        // brand route

    }

    private function getBrandKeys()
    {
        return array_map(function ($i) {
            return $i['value'];
        }, $this->options['fields']['brand']);
    }

    public function setEmail($email)
    {
        $this->email = $email;

        \add_filter('plugin_row_meta', [$this, 'plugin_row_meta'], 10, 2);
    }

    public function plugin_row_meta($meta, $plugin)
    {
        $slug = $this->app->slug;

        $email = $this->email;

        $pluginId = $this->app->getPluginFileName();

        if ($pluginId !== $plugin || !\current_user_can('update_plugins')) {
            return $meta;
        }

        $text = __($email, $slug . '-email');

        $link = "mailto:{$email}";

        $meta[] = sprintf('<a href="%s">%s</a>', \esc_attr($link), $text);

        return $meta;
    }

    public function filterAddons($addons)
    {
        $filter = $this->options['addons_filter'];

        $values = [];

        foreach ($addons as $addon) {
            if (!in_array($addon->value, $filter)) {
                $values[] = $addon;
            }
        }

        return $values;
    }

    public function getOptions($key = null)
    {
        if ($key) {
            return $this->options[$key];
        } else {

        }
        return $this->options;
    }

    public function getOption($key)
    {
        return $this->options[$key];
    }

    public function settings()
    {
        if (!$this->_settings) {
            $fields = Fields::getKeys($this->options['fields']);
            $this->_settings = Settings::create($this->app, $fields, 'brand_settings');
        }

        return $this->_settings;
    }

}
