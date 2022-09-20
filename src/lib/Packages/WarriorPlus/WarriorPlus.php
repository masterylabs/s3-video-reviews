<?php

namespace Masteryl\Packages\WarriorPlus;

use Masteryl\Helpers\Url;
use Masteryl\Remote\Remote;

class WarriorPlus
{
    protected $api = 'https://warriorplus.com/api/v2';

    protected $endpoint;

    protected $api_key;

    protected $params = [
        'limit',
        'starting_after',
        'ending_before',
    ];

    protected $limit = 48;

    protected $cache_expire = 11111440; // 60; // minutes

    private $cache;

    public function __construct($apiKey = null)
    {
        if ($apiKey) {
            $this->api_key = $apiKey;
        }
    }

    public function setApiKey($key)
    {
        $this->api_key = $key;
    }

    public function useCache($model, $mins = false)
    {
        $this->cache = $model;

        if ($mins) {
            $this->cache_expire = $mins;
        }
    }

    public function setCacheAge($mins)
    {
        $this->cache_expire = $mins;
    }

    public function get($endpoint, $args = null)
    {
        // if is list

        $url = $this->getUrl($endpoint, $args); // $this->api . '/' . $endpoint . '?apiKey=' . $this->api_key;

        if ($this->cache) {
            $cache = $this->cache::where('url', $url)->first();

            if ($cache && $cache->minutes($this->cache_expire)) {

                // check age
                return $cache->data;
            }
        }

        $res = Remote::get($url);

        if ($res->code === 200) {
            $res->json();
            if ($this->cache) {

                if ($this->isValidResponse($res)) {
                    $name = $this->getCacheName($endpoint);
                    $this->cache::createOrUpdate(['url' => $url], ['data' => $res->body, 'name' => $name]);
                }

            }
        }

        return $res->body;
    }

    private function isValidResponse($res)
    {
        $body = $res->body;

        if (empty($body)) {
            return false;
        }

        if (isset($body->object) && $body->object === 'object' && is_null($body->total_count)) {
            // ee('invalid');
            return false;
        }

        // ee('valid', [$body, is_null($body->total_count)]);

        return true;
    }

    /**
     * Methods
     */
    // public function sales($args = null)
    // {
    //     return $this->get('sales', $args);
    // }

    // public function offers($args = null)
    // {
    //     return $this->get('offers', $args);
    // }

    // public function products($args = null)
    // {
    //     return $this->get('products', $args);
    // }

    // public function affiliates($args = null)
    // {
    //     return $this->get('affiliates', $args);
    // }

    public function getUrl($endpoint, $args = [])
    {

        $isList = strstr($endpoint, '/') === false;

        $url = $this->api . '/' . $endpoint . '?apiKey=' . $this->api_key;

        return Url::append($url, $args, $this->params);
    }

    public function getCacheName($endpoint)
    {
        return 'warriorplus:' . $endpoint;
    }

}
