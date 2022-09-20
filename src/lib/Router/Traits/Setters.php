<?php

namespace Masteryl\Router\Traits;

trait Setters
{

    // set is required for middleware

    private function setRequest($req)
    {
        $this->request = $req;
    }

    // set is required for middleware

    // private function setResponse($req)
    // {
    //     $this->response = $req;
    // }
}
