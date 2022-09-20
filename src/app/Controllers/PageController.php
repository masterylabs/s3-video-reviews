<?php

namespace S3VideoReviews\Controllers;

use S3VideoReviews\Models\Page;

class PageController
{
    public function nameExists($req, $res)
    {
        $page = Page::where('bucket_name', $req->bucket_name)->first(['id']);

        // if (!$page) {
        //     return $res->success();
        // }

        return $res->json(['exists' => !!$page]);
    }
}
