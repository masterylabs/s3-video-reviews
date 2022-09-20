<?php

namespace Masteryl\WPLoader;

class WPLoader
{
    protected $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function menuPage($items)
    {

        \add_action('admin_menu', function () use ($items) {
            if (!is_array($items)) {
                $items = [$items];
            }

            foreach ($items as $item) {
                $class = new $item;
                $class->loader($this->app);
            }
        });

    }

    public function metaBox($items)
    {
        \add_action('add_meta_boxes', function () use ($items) {

            if (!is_array($items)) {
                $items = [$items];
            }

            foreach ($items as $item) {
                $class = new $item;
                $class->loader($this->app);
            }

        });
    }

    public function shortcode($key, $class, $args = [])
    {
        if (!empty($args['prefix'])) {
            $prefix = is_bool($args['prefix']) ? $this->app->id . '_' : $args['prefix'];
            $key = $prefix . $key;
        }

        \add_shortcode($key, function ($atts = [], $content = '') use ($class) {

            if (!is_array($atts)) {
                $atts = [];
                // ee('empty', $atts);
            }
            if (is_array($class)) {
                $handle = $class[1];
                $class = $class[0];
            } else {
                $handle = 'handle';
            }

            $model = new $class($this->app, $atts);

            return $model->{$handle}($atts, $content);
        });
    }

    public function titleShortcode($codes, $args = [])
    {
        if (is_string($codes)) {
            $codes = [$codes];
        }

        if (!empty($args['prefix'])) {
            $prefix = is_bool($args['prefix']) ? $this->app->id . '_' : $args['prefix'];

            foreach ($codes as $index => $code) {
                $codes[$index] = $prefix . $code;
            }
        }

        \add_filter('document_title_parts', function ($titles) use ($codes) {

            foreach ($codes as $code) {

                foreach ($titles as $key => $title) {

                    $n = strpos($title, '[' . $code);
                    if ($n !== false) {
                        $titles[$key] = do_shortcode($title);
                    }
                }
            }

            return $titles;
        });

        add_filter('the_title', function ($content) {

            if (is_admin()) {
                return $content;
            }

            return do_shortcode($content);
        }, 1);

    }

}
