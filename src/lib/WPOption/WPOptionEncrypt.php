<?php

namespace Masteryl\WPOption;

use Masteryl\WPOption\WPOption;

class WPOptionEncrypt extends WPOption
{
    private function getOption()
    {
        ee('encrypted getOption');
        return get_option($this->db_key);
    }

    private function setOption($value)
    {
        update_option($this->db_key, $value);
    }
}
