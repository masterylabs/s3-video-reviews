<?php

namespace Masteryl\Migration\Traits;

trait Builder
{

    private $builder_cols = [];

    private $builder_args = [];

    // protected $foreign_key_constraints;

    public function clearBuilder()
    {
        $this->builder_cols = [];
        $this->builder_args = [];

        return $this;
    }

    public function id($name = 'id', $len = 9, $type = 'MEDIUMINT')
    {
        $this->builder_cols[] = [
            'name' => $name,
            'type' => $type,
            'length' => $len,
            'auto_increment' => true,
            'primary_key' => true,
            'not_null' => true,
        ];

        return $this;
    }

    public function identifier($name = 'identifier', $len = 32)
    {
        $this->builder_cols[] = [
            'name' => $name,
            'type' => 'varchar',
            'length' => $len,
            'unique' => true,
            'not_null' => true,
        ];

        return $this;
    }

    public function string($name, $len = 255)
    {
        if ($this->varchar_max && $this->varchar_max < $len) {
            $len = $this->varchar_max;
        }

        $this->builder_cols[] = [
            'name' => $name,
            'type' => 'varchar',
            'length' => $len,
            'not_null' => true,
        ];

        return $this;
    }

    public function text($name, $type = 'text')
    {
        $this->builder_cols[] = [
            'name' => $name,
            'type' => $type,
            // 'not_null' => true,
        ];

        return $this;
    }

    public function longtext($name)
    {
        return $this->text($name, 'longtext');
    }

    public function mediumtext($name)
    {
        return $this->text($name, 'mediumtext');
    }

    public function integer($name, $len = 11, $def = null, $type = 'int')
    {
        $this->builder_cols[] = [
            'name' => $name,
            'type' => $type,
            'length' => $len,
            'default_value' => $def,
            'not_null' => true,
        ];

        return $this;
    }

    public function boolean($name, $def = 0)
    {
        return $this->integer($name, 1, $def, 'tinyint');
    }

    public function decimal($name, $a, $b)
    {
        return $this->integer($name, "{$a},{$b}", 0, 'decimal');
    }

    public function double($name, $a, $b)
    {
        return $this->integer($name, "{$a},{$b}", 0, 'double');
    }

    public function float($name, $a, $b)
    {
        return $this->integer($name, "{$a},{$b}", 0, 'float');
    }

    public function datetime($name)
    {
        $this->builder_cols[] = [
            'name' => $name,
            'type' => 'datetime',
            'not_null' => true,
        ];

        return $this;
    }

    public function timestamps()
    {
        return $this->datetime('created')->datetime('updated');
    }

    public function unique()
    {
        return $this->builderColLast('unique', true);
    }

    public function index()
    {
        return $this->builderColLast('index', true);
    }

    public function nullable()
    {
        return $this->builderColLast('not_null', false);
    }

    public function unsigned()
    {
        return $this->builderColLast('unsigned', true);
    }

    public function after($value)
    {
        return $this->builderColLast('after', $value);
    }

    public function first($value)
    {
        return $this->builderColLast('first', true);
    }

    public function defaultValue($val)
    {
        return $this->builderColLast('default_value', $val);
    }

    private function builderColLast($key, $val)
    {
        $index = count($this->builder_cols) - 1;
        $this->builder_cols[$index][$key] = $val;
        return $this;
    }

    public function foreign($colName)
    {
        if (!isset($this->builder_args['foreign_key_constraints'])) {
            $this->builder_args['foreign_key_constraints'] = [];
        }

        $this->builder_args['foreign_key_constraints'][] = [
            'foreign_key' => $colName,
        ];

        return $this;
    }

    public function references($colName)
    {
        $index = count($this->builder_args['foreign_key_constraints']) - 1;

        $this->builder_args['foreign_key_constraints'][$index]['references'] = $colName;

        return $this;
    }

    public function on($table)
    {
        $index = count($this->builder_args['foreign_key_constraints']) - 1;

        $this->builder_args['foreign_key_constraints'][$index]['table'] = $table;

        return $this;
    }

}
