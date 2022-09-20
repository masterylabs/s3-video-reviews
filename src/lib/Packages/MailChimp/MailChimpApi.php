<?php

namespace Masteryl\Packages\MailChimp;

use Masteryl\Packages\MailChimp\Traits\Base;
use Masteryl\Packages\MailChimp\Traits\Request;

class MailChimpApi
{
    use Base, Request;

    public function index($req, $res)
    {
        $re = $this->request('GET');

        return $res->json($re->body, $re->code);
    }

    public function show($req, $res)
    {
        $id = !empty($req->id2) ? $req->id2 : $req->id;

        $re = $this->request('GET', $id);

        return $res->json($re->body, $re->code);

    }

    public function get($endpoint = '')
    {
        return $this->request('GET', $endpoint);
    }

    public static function routes($router)
    {
        $router->get('mailchimp/{endpoint}', [self::class, 'index']);
        $router->get('mailchimp/{endpoint}/{id}', [self::class, 'show']);
        $router->get('mailchimp/{endpoint}/{id}/{endpoint2}', [self::class, 'index']);
        $router->get('mailchimp/{endpoint}/{id}/{endpoint2}/{id2}', [self::class, 'show']);
    }

}
