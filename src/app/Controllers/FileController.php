<?php

namespace S3VideoReviews\Controllers;

use Masteryl\FileSystem\FileSystem;
use Masteryl\Helpers\Str;
use S3VideoReviews\Models\Page;
use S3VideoReviews\PageBuilder;

class FileController
{

    protected $app;

    protected $req;

    protected $page;

    protected $settings;

    protected $fs;

    protected $page_cols = [
        // 'identifier',
        // 'user_id|hidden',
        'parent_id',
        'page_type',
        'name',
        'description',
        'slug',
        'checkout_url',
        'cancel_url',
        'prod_name',
        'admin_image',
        'favicon',
        'theme',
        'meta',
        'header_code',
        'footer_code',
        'bg',
        'seo',
        'body',
        'opts',
    ];

    protected $website_files = [
        'css/app.css',
        'css/chunk-common.css',
        'css/chunk-vendors.css',
        'css/live.css',
        'js/app.js',
        'js/chunk-common.js',
        'js/chunk-vendors.js',
        'js/live.js',
        "images/cards/amex.svg",
        "images/cards/discovery.svg",
        "images/cards/mastercard.svg",
        "images/cards/paypal.svg",
        "images/cards/visa.svg",
    ];

    public function __construct($req, $res)
    {
        $this->page = Page::find($req->id, $this->page_cols);

        if (!$this->page) {
            return $res->notFound();
        }

        $this->app = $req->app;

        $this->req = $req;

        $this->settings = $req->app->settings;

        $this->fs = new FileSystem();

    }

    public function __invoke($req, $res)
    {
        $files = [];

        $files[] = $this->getPage();

        // if get all

        // js
        $files = $this->appendJs($files);

        // styles
        $files = $this->appendCss($files);

        // images
        $files = $this->appendImages($files);

        //

        return $res->data($files);

    }

    // Offer File Names

    public function offerFileNames($req, $res)
    {

        $names = $this->website_files;

        $offer = Page::find($req->id, ['id', 'slug', 'parent_id']);

        if (!$offer) {
            return $res->notFound();
        }

        $names[] = 'index.html';

        $pages = $offer->pages()->get(['id', 'slug']);

        if (!empty($pages)) {
            foreach ($pages as $p) {
                $names[] = $this->getBucketFileName($p->slug);
            }
        }

        return $res->data($names);
    }

    public function indexPage($req, $res)
    {
        $page = $this->getPage();

        // return $this->devIndexPage($page['contents']);

        return $res->data($page);
    }

    // Dev

    private function devIndexPage($str)
    {
        $prefix = 'http://s3videooffers-plugin.test/public/client/';

        $str = str_replace(' href="/', ' href="' . $prefix, $str);
        $str = str_replace(' src="/', ' src="' . $prefix, $str);

        exit($str);
    }

    /**
     * Privates
     */

    private function getPage()
    {
        $pb = new PageBuilder($this->app, $this->page);

        $contents = $pb->getPage();

        return [
            'fileName' => 'index.html',
            'type' => 'text/html',
            'contents' => $contents,
        ];

    }

    private function appendImages($files)
    {
        $cards = FileSystem::getFilesWithContent($this->app->plugin_dir . '/public/images/cards');

        foreach ($cards as $item) {

            $files[] = [
                'fileName' => 'images/cards/' . $item['fileName'],
                'type' => 'image/svg+xml',
                'contents' => $item['contents'],
            ];
        }

        return $files;

        // $cart = FileSystem::getFilesWithContent($this->app->plugin_dir . '/public/images/cart');
    }

    private function appendCss($files)
    {
        $items = FileSystem::getFilesWithContent($this->app->plugin_dir . '/public/client/css');

        foreach ($items as $item) {
            if ($item['name'] === 'app') {
                continue;
            }

            $files[] = [
                'fileName' => 'css/' . $item['fileName'],
                'type' => 'text/css',
                'contents' => $item['contents'],
            ];
        }

        return $files;
    }

    private function appendJs($files)
    {
        $items = FileSystem::getFilesWithContent($this->app->plugin_dir . '/public/client/js');

        foreach ($items as $item) {
            if ($item['name'] === 'app') {
                continue;
            }

            $files[] = [
                'fileName' => 'js/' . $item['fileName'],
                'type' => 'text/javascript',
                'contents' => $item['contents'],
            ];
        }

        return $files;
    }

    private function getBucketFileName($slug)
    {
        if (Str::endsWith($slug, '.html')) {
            return $slug;
        }
        return rtrim($slug, '/') . '/index.html';
    }

}
