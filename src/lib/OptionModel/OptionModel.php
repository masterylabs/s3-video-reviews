<?php

namespace Masteryl\OptionModel;

use Masteryl\Model\Model;

class OptionModel extends Model
{
    protected $option_name_prefix = '_';

    private $_is_fetched = false;

    protected function storeUpdate()
    {
        // ee('storeUpdate');

        if (!$this->_is_fetched) {
            $dbValues = $this->getOptionValue();

            if ($dbValues) {
                $this->mergeResult($dbValues);
            }
        }

        $data = json_encode($this);

        $key = $this->getOptionKey();

        update_option($key, $data);

    }

    protected function storeCreate()
    {
        $data = json_encode($this);

        $key = $this->getOptionKey();

        update_option($key, $data);
    }

    public function _get()
    {
        $result = $this->getOptionValue();

        if ($result) {
            $this->loadResult($result);
        }

        return $this;
    }

    public function _first()
    {
        return $this->_get();
    }

    /**
     * Privates
     */

    private function getOptionValue()
    {
        $this->_is_fetched = true;

        $key = $this->getOptionKey();
        $result = get_option($key);

        if ($result) {
            $result = json_decode($result);
        }

        return $result;
    }

    private function getOptionKey()
    {
        return $this->option_name_prefix . $this->_table;
    }
}
