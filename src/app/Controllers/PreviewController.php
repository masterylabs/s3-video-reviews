<?php

namespace S3VideoReviews\Controllers;

use S3VideoReviews\Models\Page;
use S3VideoReviews\PageBuilder;

class PreviewController
{
    protected $page_cols = [
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

    public function __invoke($req, $res)
    {
        $page = Page::find($req->id, $this->page_cols);

        if (!$page) {
            return $res->notFound();
        }

        $pb = new PageBuilder($req->app, $page);

        $pb->setPreview();

        $contents = $pb->getPage();

        exit($contents);

    }
}
