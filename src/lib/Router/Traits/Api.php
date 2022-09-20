<?php

namespace Masteryl\Router\Traits;

trait Api
{
    public function allowCors($val = '*')
    {
        header("Access-Control-Allow-Origin: " . $val);
        header("Access-Control-Allow-Headers: " . $val);
        header("Access-Control-Allow-Methods: " . $val);
    }

}
