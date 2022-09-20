<?php

namespace S3VideoReviews\Collections;

use Masteryl\Collection\Collection;
use S3VideoReviews\Models\Page;

class PageCollection extends Collection
{

    protected $req;

    protected $index_cols = [
        'id',
        'identifier',
        'user_id',
        'parent_id',
        'page_type',
        'name',
        'description',
        'slug',
        'checkout_url',
        'prod_name',
        'admin_image',
        'bucket_name',
        'bucket_region',
        'bucket_cloudfront',
        'bucket_domain',

        'opts',
    ];

    protected $parent_cols = [
        'id',
        'page_type',
        'name',
        'description',
        'slug',
        'theme',
        'bg',
        'body', // need for new preview
        'bucket_name',
        'bucket_region',
        'bucket_cloudfront',
        'bucket_domain',
    ];

    protected $custom_keys = [
        'page' => 'page_id',
    ];

    public function getModel()
    {
        // sleep(1);
        return new Page;
    }

    public function index($req, $res)
    {

        $items = $this->getModel()
            ->queryParams($req)->whereIsNull('parent_id')
            ->paginate()->get($this->index_cols);

        return $res->json($items);
    }

    public function showAppend($data)
    {
        ee('show append');
        $item = $data['data'];

        if (!empty($item->parent_id)) {
            $data['parent'] = Masteryl_Page::find($item->parent_id, $this->parent_cols);
        }

        return $data;
    }

    public function queryAppendIndex($page)
    {
        $page->andWhere('parent_id', null);
        return $page;
    }

    /**
     * Sub Pages
     */
    public function pages_index($req, $res)
    {

        $items = $this->getModel()
            ->queryParams($req)->where('parent_id', $req->id)
            ->paginate()->get($this->index_cols);

        return $res->json($items);
    }

    public function pages_show($req, $res)
    {
        $page = $this->getModel()
            ->where('parent_id', $req->id)
            ->where('id', $req->page)
            ->first();

        if (!$page) {
            return $res->notFound();
        }

        $data = [
            'data' => $page,
            'parent' => Page::find($req->id, $this->parent_cols),
        ];

        return $res->json($data);
    }

    public function pages_update($req, $res)
    {
        $page = $this->getModel()
            ->where('parent_id', $req->id)
            ->where('id', $req->page)
            ->first();

        if (!$page) {
            return $res->notFound();
        }

        $page->update($req);

        return $res->success('Updated!');
    }

    public function pages_destroy($req, $res)
    {
        $page = $this->getModel()
            ->where('parent_id', $req->id)
            ->where('id', $req->page)
            ->first(['id']);

        if (!$page) {
            return $res->notFound();
        }

        $page->destroy();

        return $res->success('Deleted!');
    }

}
