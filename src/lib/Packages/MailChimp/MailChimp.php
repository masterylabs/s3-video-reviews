<?php

namespace Masteryl\Packages\MailChimp;

use Masteryl\Packages\MailChimp\Traits\Base;
use Masteryl\Traits\ApiRequestor;

class MailChimp
{
    use Base, ApiRequestor;

    protected $list_id;

    public function lists()
    {
        $this->endpoint = 'lists';

        return $this;
    }

    public function setList($id)
    {
        $this->list_id = $id;
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
            'email_address' => $data['email'],
            'status' => 'subscribed',
            'merge_fields' => [],
        ];

        // single name

        if (!empty($data['name'])) {
            $names = explode(' ', $data['name']);
            $body['merge_fields']['FNAME'] = array_shift($names);

            if (!empty($names)) {
                $body['merge_fields']['LNAME'] = implode(' ', $names);
            }
        }

        // first and last name

        else {
            if (!empty($body['first_name'])) {
                $body['merge_fields']['FNAME'] = $body['first_name'];
            }
            if (!empty($body['last_name'])) {
                $body['merge_fields']['FNAME'] = $body['last_name'];
            }

        }

        if (!empty($data['ip_address'])) {
            $body['ipAddress'] = $data['ip_address'];
        }

        $endpoint = 'lists/' . $this->list_id . '/members';

        // requires encode for mailchimp
        $body = json_encode($body);

        $res = $this->request('POST', $endpoint, $body, true);

        if ($res->code === 200) {
            $this->subscriber_added = true;
        } elseif ($res->code === 400) {
            $this->already_subscribed = true;
        } else {
            $this->responseHandler($res);
        }

    }

    public function getSelectItems($meta = false)
    {
        $this->request();

        if ($this->requestError()) {
            return false;
        }

        $items = [];

        if ($this->endpoint === 'lists') {
            foreach ($this->response_body->lists as $item) {
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

    public function get()
    {
        $this->request();

        if ($this->requestError()) {
            return false;
        }

        return $this->response_body;
    }

}
