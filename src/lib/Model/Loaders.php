<?php
namespace Masteryl\Model;

use Masteryl\QueryBuilder\QueryBuilder;

trait Loaders
{
    public function loadBuilder()
    {
        $this->builder = new QueryBuilder($this->app->db, $this->_table);
    }

    // ONLY ADD IF NOT SET!

    protected function mergeResult($item)
    {
        $this->loadResult($item, true);
    }

    // REPLACES ALL WITH NEW

    protected function loadResult($item, $mergeOnly = false)
    {

        foreach ($item as $key => $val) {

            $this->_db_value[$key] = $val;

            if ($mergeOnly && isset($this->{$key})) {
                continue;
            }

            // prepare value for datbase

            $val = $this->unparseCol($key, $val);

            if (is_null($val)) {
                continue;
            }

            if ($this->_hidden && in_array($key, $this->_hidden)) {
                $this->_hidden_values[$key] = $val;
                continue;
            }

            $this->{$key} = $val;
        }
    }

    private function loadModelData($data)
    {
        $validProps = array_merge($this->fills, ['id', 'created', 'updated']);

        foreach ($data as $key => $val) {
            if (in_array($key, $validProps)) {
                $this->{$key} = $this->unparseCol($key, $val);
            }
        }
    }

    private function loadBuilderValues($nonFillKeys = null)
    {

        $builder = $this->getBuilder();

        foreach ($this->fills as $key) {
            if (isset($this->{$key})) {
                // parse for database
                $val = $this->parseCol($key, $this->{$key});

                // make sure it has changes
                $match = isset($this->_db_value[$key]) && $this->_db_value[$key] == $val ? 1 : 0;

                if (!$match) {
                    $builder->addValue($key, $val);
                }

            }
        }

        // created, updated
        if ($nonFillKeys) {
            foreach ($nonFillKeys as $key) {
                if (isset($this->{$key})) {
                    $builder->addValue($key, $this->{$key});
                }
            }
        }

    }

}
