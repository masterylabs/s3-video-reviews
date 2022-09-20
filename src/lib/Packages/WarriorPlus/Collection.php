<?php

namespace Masteryl\Packages\WarriorPlus;

class Collection
{
    protected $wp; // WarriorPlus: set during construct

    // public function __construct()
    // {
    //     $this->wp = new WarriorPlus;

    //         // set license key in contruct
    // }

    protected $map_endpoints = [
        'affiliate-requests' => 'affiliate_requests',
    ];

    public static function routes($router, $path = 'warriorplus')
    {
        $router->get($path . '/{endpoint}', [static::class, 'call']);
        $router->post($path . '/{endpoint}/clear-cache', [static::class, 'clearCache']);
        return;

        // $routes = [
        //     'affiliate-requests',
        //     'affiliates',
        //     'sales',
        //     'offers',
        //     'products',
        //     'customers',
        //     'payments',
        //     'purchases',
        // ];

        // foreach ($routes as $route) {
        //     $method = Str::toCamel($route);
        //     $router->get($path . '/' . $route, [static::class, $method]);
        // }

    }

    public function call($req, $res)
    {
        $endpoint = $req->endpoint;

        if (isset($this->map_endpoints[$endpoint])) {
            $endpoint = $this->map_endpoints[$endpoint];
        }

        // $url = $this->wp->getUrl($endpoint, $req);

        $result = $this->wp->get($endpoint, $req);

        $result = $this->parseResult($result);

        return $res->json($result);
    }

    public function parseResult($result)
    {
        if (!is_object($result)) {
            return $result; // something is wrong
        }

        if (isset($result->has_more) && is_string($result->has_more)) {
            $result->has_more = settype($result->has_more, 'bool');
        }

        return $result;
    }

    public function affiliateRequests($req, $res)
    {
        $items = $this->wp->get('affiliate_requests', $req);

        return $res->json($items);

    }

    public function customers($req, $res)
    {
        $items = $this->wp->get('customers', $req);

        return $res->json($items);

    }

    public function payments($req, $res)
    {
        $items = $this->wp->get('payments', $req);

        return $res->json($items);

    }

    public function purchases($req, $res)
    {
        $items = $this->wp->get('purchases', $req);

        return $res->json($items);

    }

    public function sales($req, $res)
    {
        $items = $this->wp->get('sales', $req);

        return $res->json($items);
    }

    public function offers($req, $res)
    {
        $items = $this->wp->get('offers', $req);

        return $res->json($items);
    }

    public function products($req, $res)
    {
        $items = $this->wp->get('products', $req);

        return $res->json($items);
    }

    public function affiliates($req, $res)
    {
        $items = $this->wp->get('affiliates', $req);

        return $res->json($items);
    }

}
