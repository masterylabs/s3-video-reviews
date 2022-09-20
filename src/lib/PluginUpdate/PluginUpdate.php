<?php

namespace Masteryl\PluginUpdate;

class PluginUpdate
{
    protected $app;

    protected $plugin;

    protected $slug;

    protected $check_minutes = 720;

    protected $transient_key;

    protected $manual_check_url_key;

    protected $version;

    public function __construct($app)
    {

        $this->app = $app;

        $this->plugin = $app->getPluginFileName();

        $this->slug = $this->app->slug;

        $this->transient_key = $app->id . '_wp_update_checker';

        $this->manual_check_url_key = $this->slug . '-check-updates';

        if (!empty($_GET) && isset($_GET[$this->manual_check_url_key])) {
            \add_action('plugins_loaded', function () {
                \delete_transient($this->transient_key);
                $url = \self_admin_url('plugins.php');
                \wp_redirect($url, 302);
                exit;
            });
        }

    }

    public function updatePlugins($plugins)
    {

        if (!is_object($plugins)) {
            return $plugins;
        }

        $update = $this->getUpdate();

        // exists and is valid
        if (!$update || empty($update->version)) {
            return $plugins;
        }

        // new version exists?

        if (version_compare($update->version, $this->app->version, '<=')) {
            return $plugins;
        }

        // prepare plugins response

        if (!isset($plugins->response) || !is_array($plugins->response)) {
            $plugins->response = [];
        }

        $key = $this->plugin;

        $plugins->response[$key] = (object) [
            'slug' => $this->slug,
            'new_version' => $update->version,
            'package' => $update->download_url,
        ];

        // ee('updatePlugins', $plugins->response);

        return $plugins;
    }

    protected function getUpdate()
    {
        // check if transiet exists, if not get new
        $value = \get_transient($this->transient_key);

        if ($value) {
            return $value;
        }

        $value = $this->app->client->getUpdate();

        if ($value) {
            \set_transient($this->transient_key, $value, $this->check_minutes * 60);
        }

        return $value;
    }

    /**
     * Manual Update
     */

    public function manualCheckLink($meta, $plugin)
    {
        if ($plugin !== $this->plugin || !\current_user_can('update_plugins')) {
            return $meta;
        }

        // check url
        $args = [
            $this->manual_check_url_key => 1,
            'mmcd_slug' => $this->app->slug,
        ];

        $link = \add_query_arg($args, \self_admin_url('plugins.php'));

        $text = __('Check for updates', 'plugin-update-checker');

        $meta[] = sprintf('<a href="%s">%s</a>', \esc_attr($link), $text);

        return $meta;
    }

    /**
     * Static leader helper
     */

    public static function enable($app)
    {

        $class = new self($app);

        \add_filter('transient_update_plugins', [$class, 'updatePlugins']);
        \add_filter('site_transient_update_plugins', [$class, 'updatePlugins']);
        \add_filter('plugin_row_meta', [$class, 'manualCheckLink'], 10, 2);

    }

}
