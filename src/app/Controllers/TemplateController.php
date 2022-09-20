<?php

namespace S3VideoReviews\Controllers;

class TemplateController
{
    public function __invoke($req, $res)
    {

        return $res->jsonView('templates/' . $req->template);

        ee([$req, $key, $app]);
    }
}
