<?php

namespace Masteryl\Oauth2\Traits;

trait Setters
{
    public function setAuth($id = false, $secret = false)
    {
        if ($id) {
            $this->client_id = $id;
        }

        if ($secret) {
            $this->client_secret = $secret;
        }

    }

    public function setClientId($id)
    {
        $this->client_id = $id;
    }

    public function setClientSecret($secret)
    {
        $this->client_secret = $secret;
    }

}
