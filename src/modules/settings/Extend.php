<?php
namespace Masteryl\Modules\Settings;

use Masteryl\Modules\Settings\Controller;

class Extend
{

    public function __call($name, $args)
    {

        $n = strpos($name, '__');

        if ($n !== false) {
            $method = substr($name, 0, $n);
            $prop = substr($name, $n + 2);

            $req = $args[0];
            $res = $args[1];
            $settings = $req->app->{$prop}->settings();

            $class = new Controller($req, $res, $settings);

            return $class->{$method}($req, $res);
        }
    }

    public static function routes($name, $router, $args = [])
    {
        $router->api($args, function ($router) use ($name) {
            $router->get('settings', [static::class, 'index__' . $name]);
            $router->post('settings', [static::class, 'update__' . $name]);
            $router->post('settings/delete', [static::class, 'destroy__' . $name]);
        });
    }
}
