<?php

namespace Masteryl\Packages\MailChimp\Traits;

use Masteryl\Traits\ResponseEventHandler;

trait Base
{
    use ResponseEventHandler;

    protected $api_version = '3.0';

    protected $api_key;

    protected $api_url;

    protected $endpoint;

    protected $response_code;

    protected $response_body;

    protected $valid_query_args = [
        'count',
        'offset',
    ];

    private $query_args = [];

    private $response_error;

    public function __construct($apiKey = false)
    {
        if ($apiKey) {
            $this->setAuth($apiKey);
        }

    }

    public function setAuth($apiKey)
    {
        $this->api_key = $apiKey;

        $this->setup();

    }

    private function setup()
    {
        $i = explode('-', $this->api_key);

        $this->api_url = 'https://' . end($i) . '.api.mailchimp.com/3.0';

        if (!empty($req->endpoint)) {
            $this->endpoint = '/' . $req->endpoint;
        }

        if (!empty($req->endpoint2)) {
            $this->endpoint .= '/' . $req->id . '/' . $req->endpoint2;
        }

        foreach ($this->valid_query_args as $i) {
            if (!empty($req->{$i})) {
                $this->query_args[$i] = $req->{$i};
            }
        }
    }

}
