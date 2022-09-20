<?php

namespace Masteryl\WPMenuPage;

use Masteryl\Helpers\Vue;
use Masteryl\Traits\ParseLangProps;
use Masteryl\WPEnque\WPEnqueTrait;

class WPMenuPage
{
    use WPEnqueTrait, ParseLangProps;

    protected $app;

    protected $parent_slug;

    protected $page_title;

    protected $menu_title;

    protected $capability = 'edit_posts'; // install_plugins

    protected $menu_slug;

    protected $menu_slug_append;

    protected $icon_url = '';

    protected $position;

    protected $scripts;

    protected $styles;

    protected $vue;

    protected $use_wp_media = true;

    private $_enque;

    // will become a trait
    public function validateLoad()
    {
        return true;
    }

    public function loader($app)
    {

        $this->app = $app;

        if (!$this->validateLoad()) {
            return;
        }

        if (!$this->page_title) {
            $this->page_title = $app->name;
        }

        if (!$this->menu_title) {
            $this->menu_title = !empty($app->menu_title) ? $app->menu_title : $app->name;
        }

        if (!$this->menu_slug) {
            $this->menu_slug = $app->slug;
        }

        if ($this->menu_slug_append) {
            $this->menu_slug .= $this->menu_slug_append;
        }

        if (strpos($this->icon_url, '/') !== false && strpos($this->icon_url, '://') === false) {
            $this->icon_url = $app->getPluginUrl('public/' . ltrim($this->icon_url, '/'));
        }

        $this->parseLangProps(['page_title', 'menu_title']);

        if (method_exists($this, 'beforeAdd')) {
            $this->beforeAdd();
        }

        // ee($this->page_title);
        if ($this->parent_slug) {
            add_submenu_page(
                $this->parent_slug,
                $this->page_title,
                $this->menu_title,
                $this->capability,
                $this->menu_slug,
                [$this, 'callHandle'],
                // $this->icon_url,
                $this->position
            );
        } else {
            add_menu_page(
                $this->page_title,
                $this->menu_title,
                $this->capability,
                $this->menu_slug,
                [$this, 'callHandle'],
                $this->icon_url,
                $this->position
            );
        }

        if (isset($_GET['page']) && $_GET['page'] === $this->menu_slug) {

            if ($this->use_wp_media) {
                wp_enqueue_media();
            }

            if ($this->vue) {
                $this->loadVue();
            }

            if (method_exists($this, 'beforeLoad')) {
                $this->beforeLoad();
            }

            if (method_exists($this, 'head')) {
                $this->head();
            }

            add_action('admin_head', [$this, '_adminHead']);

            add_action('admin_enqueue_scripts', [$this, 'enqueueScripts']);

            $this->enqueueStyles();
        }
    }

    public function loadVue()
    {
        $vue = new Vue($this->app, $this->vue);
        $vue->setApi();

        if ($this->app->userAuth) {
            $vue->setAuth($this->app->userAuth);
        }

        $this->vue = $vue;
    }

    public function _adminHead()
    {
        if ($this->use_wp_media) {
            $url = $this->app->getPluginUrl('public/js/wp-media.js');
            echo '<script src="' . $url . '"></script>';
        }
        $this->adminHead();
    }

    public function adminHead()
    {
        // ee('admin head');
        if ($this->vue) {
            $this->vue->head();
        }
    }

    public function beforeLoad()
    {

        // wp_deregister_style('buttons');

        // wp_enqueue_style('admin-menu');

        // wp_enqueue_style('nav-menus');
        // wp_enqueue_style('wp-pointer');
        // // wp_enqueue_style('widgets');
        // wp_enqueue_style('site-icon');
        // wp_enqueue_style('dashicons');
        // // wp_enqueue_style('common');
        // wp_enqueue_style('dashboard');
        // // wp_enqueue_style('themes');
    }

    public function callHandle()
    {
        if ($this->vue) {
            return $this->vue->body();
        }

        $req = $this->app->request;

        $res = $this->app->response;

        return $this->handle($req, $res);
    }
}
