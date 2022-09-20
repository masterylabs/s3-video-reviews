<?php

namespace Masteryl\Oauth2\Traits;

trait Methods
{

    public function refreshToken()
    {
        $token = $this->getRefreshToken();

        if (empty($token)) {
            return false;
        }

        $params = [
            'grant_type' => 'refresh_token',
            'refresh_token' => $token,
        ];

        $json = $this->request('token', $params);

        if (method_exists($this, 'onRefreshToken')) {
            $this->onRefreshToken($json);
        }

        if (method_exists($this, 'setToken')) {
            $this->setToken($json);
        }

        // foreach ($json as $key => $val) {
        //     $this->{$key} = $val;
        // }

        return $json;
    }

    public function validateState($state)
    {
        $data = json_decode(base64_decode($state));

        if (!is_object($data)) {
            return false;
        }

        if ($data->name !== get_bloginfo('name') || $data->url !== get_bloginfo('url')) {
            return false;
        }

        $this->state_values = $data;

        return true;

        $elapsed = current_time('U') - $data->created;

        return $elapsed < 180; // 3 minutes
    }
}
