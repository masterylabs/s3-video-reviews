<?php

namespace Masteryl\WPOptionModel;

use Masteryl\Model\Model;

class WPOptionModel extends Model
{
    protected $table = 'options';

    protected $primary_key = 'option_id';

    protected $app_prefix = false;

    public function onBuilder($builder)
    {
        $name = $this->getOptionName();

        $builder->addWhere('option_name', '=', $name);

        $pk = $this->primary_key;

        $exists = $builder->getFirst($pk);

        if ($exists) {
            $this->{$pk} = $exists->{$pk};
        }
    }

    public function beforeCreate()
    {
        $option_name = $this->getOptionName();

        $option_value = [];

        foreach ($this->fills as $key) {
            if (isset($this->{$key})) {
                $option_value[$key] = $this->{$key};
            }
        }

        $this->builder->setCols(compact('option_name', 'option_value'));

    }

    public function beforeUpdate()
    {
        $this->beforeCreate();
    }

    private function getOptionName()
    {
        return '_' . $this->app->id . '_settings';
    }

    public function loadModelCols($item)
    {
        if (empty($item->option_value)) {
            return;
        }

        $cols = json_decode($item->option_value);

        foreach ($cols as $key => $val) {
            $val = $this->unparseModelCol($key, $val);
            $this->{$key} = $val;
        }

    }
}
