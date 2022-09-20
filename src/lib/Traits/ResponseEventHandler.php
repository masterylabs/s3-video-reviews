<?php

namespace Masteryl\Traits;

trait ResponseEventHandler
{
    private $_on_response_error;

    private $_on_response_success;

    public function onResponseError($func)
    {
        $this->_on_response_error = $func;
    }

    public function onResponseSuccess($func)
    {
        $this->_on_response_success = $func;
    }

    protected function responseHandler($res, $naCode = 400)
    {
        $code = !empty($res) && isset($res->code) ? $res->code : $naCode;

        // error
        // ee('responseHandler', $code);

        if ($code >= 300 && $this->_on_response_error) {
            $body = isset($res->body) ? $res->body : null;

            call_user_func($this->_on_response_error, $body, $code);
        }

        // success

        elseif ($code < 300 && $this->_on_response_success) {
            $body = isset($res->body) ? $res->body : null;

            call_user_func($this->_on_response_success, $json->body, $code);
        }
    }

}
