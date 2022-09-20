<?php

namespace Masteryl\App\Traits;

use Masteryl\App\Env;
use Masteryl\Helpers\Server;
use Masteryl\Helpers\Str;
use Masteryl\Lang\Lang;
use Masteryl\Option\Option;
use Masteryl\PluginUpdate\PluginUpdate;
use Masteryl\Request\Request;
use Masteryl\Response\Response;
use Masteryl\Router\Router;
use Masteryl\WPLoader\WPLoader;

trait Loaders
{
	// enables WP updates
	public function option($key)
	{

		if (!$this->options) {
			$this->options = [];
		}

		if (!isset($this->options[$key])) {
			$this->options[$key] = new Option($this, $key);
		}

		return $this->options[$key];
	}

	public function canUpdate()
	{
		PluginUpdate::enable($this);
	}

	public function module($name, $options = [])
	{
		if (!$this->modules) {
			$this->modules = [];
		}

		$file = $this->plugin_dir . '/config/' . $name . '.php';

		if (file_exists($file)) {
			$opts = include $file;
			$options = array_merge($opts, $options);
		}

		$dir = $this->plugin_dir . '/modules/' . $name;

		if (file_exists($dir . '/options.php')) {
			$opts = include $dir . '/options.php';
			$options = array_merge($opts, $options);
		}

		$this->modules[$name] = [
			'dir' => $dir,
			'options' => $options,
			'name' => $name,
		];

		if (file_exists($dir . '/index.php')) {
			$app = $this;
			include $dir . '/index.php';
		}

		if (file_exists($dir . '/routes.php')) {

			if (!isset($this->router)) {
				$this->load_router();
			}

			$router = $this->router;
			include $dir . '/routes.php';
		}
	}

	public function package($name, $options = [])
	{

		$dir = $this->plugin_dir . '/app/Packages/' . Str::toCamel($name, true) . '/';

		if (file_exists($dir . 'index.php')) {
			$app = $this;
			include $dir . 'index.php';
		}

		if (file_exists($dir . 'routes.php')) {

			if (!isset($this->router)) {
				$this->load_router();
			}

			// ready for routes
			$router = $this->router;
			include $dir . 'routes.php';
		}
	}

	public function load_client_ip()
	{
		$this->client_ip = Server::clientIP();
	}

	public function load_baseurl()
	{
		$this->baseurl = $this->getUrl();
	}

	protected function load_lang()
	{
		$this->lang = new Lang($this);
	}

	protected function load_db()
	{
		global $wpdb;
		$this->db = $wpdb;
	}

	protected function load_router()
	{
		$this->router = new Router($this);

		$this->maybeLoad('config');

		if (!empty($this->config['slug'])) {
			$this->router->setPrefix($this->config['slug']);
		}
	}

	protected function load_request()
	{
		$this->request = new Request($this);
	}

	public function load_response()
	{
		$this->response = new Response($this);
	}

	protected function load_config()
	{
		$file = "{$this->plugin_dir}/config/config.php";

		if (file_exists($file)) {
			$config = include $file;
		} else {
			$config = [];
		}
		// set slug

		if (empty($config['slug'])) {
			$end = strrchr($this->plugin_file, '/');
			$config['slug'] = substr($end, 1, strlen($end) - 5);
		}

		// set id

		if (empty($config['id'])) {
			$config['id'] = str_replace('-', '_', $config['slug']);
		}

		$this->config = $config;
	}

	protected function load_plugin()
	{
		$plugin = [];

		$data = file_get_contents($this->plugin_file);

		$rows = explode(PHP_EOL, $data);

		foreach ($rows as $row) {

			$n = strpos($row, ':');

			if ($n > 0) {
				$key = trim(substr($row, 0, $n));
				$key = strtolower(str_replace(' ', '_', $key));
				$val = trim(substr($row, $n + 1));
				$plugin[$key] = $val;
			} else if (strpos($row, '*/') == true) {
				break;
			}
		}

		$this->plugin = $plugin;

		if (!isset($this->name)) {
			$this->name = $plugin['plugin_name'];
		}
	}


	protected function load_loader()
	{
		$this->loader = new WPLoader($this);
	}

	/**
	 * ENV Support
	 */
	public function load_env($path = null, $fileName = '.env')
	{
		if (!$path) {
			$path = dirname($this->plugin_dir, 1);
		}

		$this->env = new Env($path, $fileName);
	}
}
