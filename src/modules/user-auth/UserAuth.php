<?php

namespace Masteryl\Modules\UserAuth;

use Masteryl\Helpers\KeyGen;

class UserAuth
{
    protected $app;

    // protected $options;

    protected $user_id;

    protected $token;

    protected $is_valid;

    protected $meta_key;

    protected $token_model;

    protected $token_len;

    public function __construct($app, $options)
    {
        $this->app = $app;

        // $this->options = $options;

        if ($options['token_model']) {
            $this->token_model = $options['token_model'];
        } else {
            $this->meta_key = $this->_getMetaKey($options);
        }

        $this->token_len = $options['token_len'];
    }

    public function __get($key)
    {
        if (isset($this->{$key})) {
            return $this->{$key};
        }

        if ($this->token && isset($this->token->{$key})) {
            return $this->token->{$key};
        }
    }

    /**
     * Public Methods
     */
    public function setUser($id)
    {
        $this->user_id = $id;
        return $this;
    }

    /**
     * Primary Methods
     */

    public function getAccessToken($userId = 0)
    {
        return $this->getToken($userId, 'access_token');
    }

    public function getToken($userId = 0, $key = false)
    {
        $this->_setUserId($userId);

        $this->_getToken();

        if (empty($this->token)) {
            $this->_createToken();
        }

        if ($key) {
            return isset($this->token->{$key}) ? $this->token->{$key} : '';
        }

        return $this->token;

    }

    public function validateToken($token = '')
    {
        if (empty($token)) {
            return false;
        }

        $this->_validateToken($token);

        return $this->is_valid;
    }

    public function deleteToken($userId = 0)
    {
        $this->_setUserId($userId);

        if (empty($this->user_id)) {
            return false;
        }

        $this->_deleteToken();
    }

    public function refreshToken($userId)
    {
        $this->_setUserId($userId);

        $this->_createToken();

        return $this->token;

    }

    /**
     * Additional
     */

    public function createToken($userId = 0)
    {
        $this->_setUserId($userId);

        $this->_createToken();

        return $this->token;

    }

    /**
     * Privates
     */

    private function _deleteToken()
    {

        if ($this->token_model) {
            $token = $this->token_model::where('user_id', $this->user_id)->first(['id']);
            if ($token) {
                $token->destroy();
            }
        } else {
            delete_user_meta($this->user_id, $this->meta_key);
        }

        unset($this->token);

    }

    private function _validateToken($token)
    {
        // $this->is_valid = false;

        if ($this->token_model) {
            $token = $this->token_model::where('access_token', $token)->first(['user_id']);

            if ($token && !empty($token->user_id)) {
                $this->user_id = $token->user_id;
            }

            $this->is_valid = !empty($token);
            return;

        }

        $this->is_valid = false;

        $n = strpos($token, '-');
        if ($n === false) {
            return;
        }

        $userId = substr($token, 0, $n);

        if (!is_numeric($userId)) {
            return;
        }

        $this->user_id = $userId;

        $meta = get_user_meta($this->user_id, $this->meta_key, true);

        if (!$meta) {
            return;
        }

        $meta = json_decode($meta);

        $this->is_valid = !empty($meta->access_token) && $meta->access_token === $token;
    }

    private function _getToken()
    {
        // get token
        if ($this->token_model) {
            $this->token = $this->token_model::where('user_id', $this->user_id)->first();
            return;

        }

        // meta
        $token = get_user_meta($this->user_id, $this->meta_key, true);

        $this->token = $token ? json_decode($token) : null;

    }

    private function _genToken()
    {
        if ($this->token_model) {
            return KeyGen::make($this->token_len);
        }

        $len = $this->token_len - strlen($this->user_id) - 1;

        return $this->user_id . '-' . KeyGen::make($len);
    }

    private function _createToken()
    {

        $token = $this->_genToken();

        $data = [
            'provider' => 'user_auth',
            'access_token' => $token,
            'expires_at' => 0,
        ];

        if ($this->token_model) {
            $data['user_id'] = $this->user_id;
            $this->token = $this->token_model::create($data);
            return;

        }

        update_user_meta($this->user_id, $this->meta_key, json_encode($data));

        $this->token = (object) $data;

    }

    private function _setUserId($id)
    {
        if (!empty($id)) {
            $this->user_id = $id;
            return;
        }

        if (!$this->user_id) {
            $this->user_id = get_current_user_id();
        }
    }

    private function _getMetaKey($opts)
    {
        $key = $opts['meta_key'];

        if ($opts['meta_key_prefix']) {
            $key = $this->app->id . '_' . $key;
        }

        return '_' . $key;
    }

}
