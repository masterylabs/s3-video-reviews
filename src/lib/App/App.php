<?php

namespace Masteryl\App;

use Masteryl\App\Traits\Events;
use Masteryl\App\Traits\Getters;
use Masteryl\App\Traits\Loaders;
use Masteryl\Helpers\Str;
use Masteryl\Migration\Migration;
use Masteryl\Model\Model;

class App
{
    use Events, Getters, Loaders;

    protected $config;

    protected $plugin;

    protected $plugin_namespace;

    protected $plugin_dir;

    protected $plugin_file;

    protected $plugin_url;

    protected $loader;

    protected $request;

    protected $response;

    protected $router;

    protected $db;

    protected $lang;

    protected $client;

    protected $host;

    protected $modules;

    protected $env;

    protected $baseurl;

    // wp options
    protected $options;

    // module extension support

    protected $unbranded;

    protected $is_branded;

    protected $client_ip;

    private $_que;

    public function __construct($args = null)
    {

        if ($args) {
            foreach ($args as $key => $val) {
                $this->{$key} = $val;
            }
        }

        if (!isset($this->plugin_dir)) {
            $this->plugin_dir = substr(__DIR__, 0, -12);
        }

        // echo $this->plugin_namespace . "\n";

    }

    public function __get($key)
    {
        if (isset($this->{$key})) {
            return $this->{$key};
        }

        $m = "load_{$key}";

        if (method_exists($this, $m)) {
            $this->{$m}();
            return $this->{$key};
        }

        if ($this->_que && isset($this->_que[$key])) {
            return $this->callQue($key);
        }

        // not found
        if (!isset($this->config)) {
            $this->load_config();
        }

        // is it a config value
        if (isset($this->config[$key])) {
            return $this->config[$key];
        }

        // not found, try plugin info
        if (!isset($this->plugin)) {
            $this->load_plugin();
        }

        // is it a plugin value
        if (isset($this->plugin[$key])) {
            return $this->plugin[$key];
        }

    }

    public function __call($name, $args)
    {
        // Module Options

        if ($this->modules && Str::endsWith($name, 'Options')) {
            $key = Str::camelToSnake(substr($name, 0, -7));
            return $this->callModuleOptions($key, $args);
        }

    }

    public function setProp($key, $value)
    {
        $this->{$key} = $value;
    }

    public function callModuleOptions($name, $args, $key = 'options')
    {

        if (!isset($this->modules[$name])) {
            return !empty($args) ? $args[0] : null;
        }

        $value = $this->modules[$name][$key];

        // get individual key

        if (!empty($args) && is_string($args[0])) {
            $k = $args[0];
            $na = isset($args[1]) ? $args[1] : false;
            return isset($value[$k]) ? $value[$k] : $na;
        }

        return $this->modules[$name][$key];

    }

    public static function create($args = [])
    {
        return new App($args);
    }

    public function run()
    {
        if ($this->router) {
            $this->router->callRoutes();
        }
    }

    public function que($key, $cb)
    {
        if (!$this->_que) {
            $this->_que = [];
        }

        $this->_que[$key] = $cb;

    }

    public function useModels()
    {
        Model::addApp($this);
    }

    public function migrate($options = null)
    {
        Migration::migrateWithOptions($this, $options);

        // check if errors
        // support older mysqli versions
        global $wpdb;
        if (empty($options) && !empty($wpdb)) {
            // ee('check for errors', $wpdb);
            if (!empty($wpdb->last_error)) {
                Migration::migrateWithOptions($this, ['varchar_max' => 191]);
            }
        }
    }
    /**
     * Tools
     */
    //

    private function callQue($key)
    {
        $cb = $this->_que[$key];

        if (is_string($cb)) {
            $value = new $cb($this);
        } else {
            $value = call_user_func($cb, $this);
        }

        unset($this->_que[$key]);

        $this->{$key} = $value;

        return $value;
    }

    /**
     * Internal Helpers
     */

    private function maybeLoad($key)
    {
        if (!isset($this->{$key})) {
            $m = "load_{$key}";
            $this->{$m}();
        }
    }

}
