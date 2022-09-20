<?php

namespace Masteryl\Packages\Aweber;

use Masteryl\Traits\ApiRequestor;
use Masteryl\Traits\ResponseEventHandler;

class Aweber
{
    use ResponseEventHandler, ApiRequestor;

    protected $api_url = 'https://api.aweber.com/1.0';

    protected $auth;

    protected $account_id; // = 1773762;

    protected $endpoint_name;

    protected $response_body;

    protected $response_code;

    public function __construct($auth = null)
    {
        $this->auth = $auth;
    }

    public function accounts($id = false)
    {
        $this->endpoint = 'accounts';

        if ($id) {
            $this->endpoint .= '/' . $id;
        }

        return $this;
    }

    public function lists()
    {
        $this->endpoint_name = 'lists';

        // requires list
        if (empty($this->endpoint)) {

            if (empty($this->account_id)) {
                $this->account_id = $this->getFirstAccount(true);
            }

            $this->endpoint = 'accounts/' . $this->account_id;
        }

        $this->endpoint .= '/lists';

        return $this;
    }

    public function getSelectItems($meta = false)
    {

        $this->request();

        if ($this->requestError()) {
            return false;
        }

        if (empty($this->response_body)) {
            return [];
        }

        $items = [];

        if ($this->endpoint_name === 'lists') {

            if (empty($this->response_body->entries)) {
                return [];
            }

            foreach ($this->response_body->entries as $item) {
                $entry = [
                    'text' => $item->name,
                    'value' => $item->id,
                ];

                if ($meta) {
                    $entry['meta'] = $item;
                }

                $items[] = $entry;
            }

        }

        return $items;
    }

    public function getFirstAccount($idOnly = false)
    {
        $res = $this->request('GET', 'accounts');

        $body = $res->response_body;

        if (empty($body->entries)) {
            return false;
        }

        if ($idOnly) {
            return $body->entries[0]->id;
        }

        return $body->entries[0];
    }

    public function getRequestHeaders()
    {
        $auth = $this->auth->getToken();

        if ($auth->expired()) {
            ee('expired, renew token');
        }

        return [
            'Authorization' => 'Bearer ' . $auth->access_token,
            'Accept' => 'application/json',
        ];
    }

}
