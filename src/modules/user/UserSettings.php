<?php

namespace Masteryl\Modules\User;

use Masteryl\Modules\Settings\Settings;

class UserSettings extends Settings
{
    protected $user_id;

    protected function getOption()
    {
        return get_user_meta($this->user_id, $this->option_key, true);
    }

    protected function updateOption($data)
    {
        return update_user_meta($this->user_id, $this->option_key, $data);
    }

    protected function deleteOption()
    {
        return delete_user_meta($this->user_id, $this->option_key);
    }

}
