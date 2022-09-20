<?php

namespace Masteryl\Packages\GetResponse;

use Masteryl\Traits\ApiRequestor;
use Masteryl\Traits\ResponseEventHandler;

class GetResponse
{
    use ResponseEventHandler, ApiRequestor;

    protected $api_url = 'https://api.getresponse.com/v3';

    protected $api_key;

    protected $endoint;

    protected $query_args;

    protected $response_code;

    protected $response_body;

    // protected $auth_header_prefix = 'api-key ';

    public function __construct($apiKey = false)
    {
        if ($apiKey) {
            $this->setApiKey($apiKey);
        }
    }

    public function setList($id)
    {
        $this->campaign_id = $id;
        return $this;
    }

    public function addSubscriber($data)
    {
        if (is_string($data)) {
            $data = [
                'email' => $data,
            ];
        }

        $body = [
            'email' => $data['email'],
            'campaign' => [
                'campaignId' => $this->campaign_id,
            ],
        ];

        if (!empty($data['name'])) {
            $body['name'] = $data['name'];
        } elseif (!empty($data['first_name'])) {
            $body['name'] = $data['first_name'];
            if (!empty($data['last_name'])) {
                $body['name'] .= ' ' . $data['last_name'];
            }
        }

        if (!empty($data['ip_address'])) {
            $body['ipAddress'] = $data['ip_address'];
        }

        // customFieldValues
        /**
        https://apidocs.getresponse.com/v3/case-study/adding-contacts
         */

        $res = $this->request('POST', 'contacts', $body, true);

        if ($res->code === 202) {
            $this->subscriber_added = true;
        } elseif ($res->code === 409) {
            $this->already_subscribed = true;
        } else {
            $this->responseHandler($res);
        }

    }

    public function setApiKey($key)
    {
        $this->api_key = $key;
    }

    public function lists()
    {
        $this->endpoint = 'campaigns';

        return $this;
    }

    public function getSelectItems($meta = false)
    {
        $this->request();

        if ($this->requestError()) {
            return false;
        }

        $items = [];

        if ($this->endpoint === 'campaigns') {
            foreach ($this->response_body as $item) {
                $entry = [
                    'text' => $item->name,
                    'value' => $item->campaignId,
                ];

                if ($meta) {
                    $entry['meta'] = $item;
                }

                $items[] = $entry;
            }
        }

        return $items;
    }

    // public function request($method = 'GET', $endpoint = '', $body = null, $returnResponse = false)
    // {
    //     $url = $this->api_url;

    //     if (!empty($this->endpoint)) {
    //         $url .= '/' . $this->endpoint;
    //     }

    //     if ($endpoint !== '') {
    //         $url .= '/' . ltrim($endpoint, '/');
    //     }

    //     if (!empty($this->query_args)) {
    //         $url = Url::append($url, $this->query_args);
    //     }

    //     $args = [
    //         'method' => $method,
    //         'headers' => $this->getRequestHeaders(),
    //         'body' => $body,
    //     ];

    //     $res = Remote::request($url, $args)->getJson();

    //     $this->response_body = $res->body;

    //     $this->response_code = $res->code;

    //     if ($returnResponse) {
    //         return $res;
    //     }

    //     $this->responseHandler($res);

    //     return $this;
    // }

    public function getRequestHeaders()
    {
        return [
            'X-Auth-Token' => 'api-key ' . $this->api_key,
            'Accept' => 'application/json',
        ];
    }

    public function requestError()
    {
        return empty($this->response_code) || $this->response_code >= 300;
    }
}
