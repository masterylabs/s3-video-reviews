<?php

namespace Masteryl\Model;

use Masteryl\Helpers\KeyGen;

trait Save
{
    public function _id($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Called as save
     */

    public function _save($data = null)
    {
        return empty($this->id) ? $this->_create($data) : $this->_update($data);
    }

    public function _create($data = null)
    {
        if ($this->timestamps) {
            $this->created = date('Y-m-d H:i:s');
            $this->updated = $this->created;
        }

        if ($data) {
            $this->loadModelData($data);
        }

        if (method_exists($this, 'beforeCreate')) {
            $this->beforeCreate();
        }

        // ee('create', $this);

        if (in_array('identifier', $this->fills) && empty($this->identifier) || ($this->use_identifier && empty($this->identifier))) {
            $this->identifier = KeyGen::make($this->identifier_len, $this->identifier_prefix);
            $this->getBuilder()->addValue('identifier', $this->identifier);
        }

        $this->storeCreate();

        return $this;
    }

    // part of create that is unique to model using builder

    protected function storeCreate()
    {
        $this->loadBuilderValues(['created', 'updated']);

        $builder = $this->getBuilder();

        if ($this->_belongs_to) {
            $builder->addValue($this->_belongs_to[0], $this->_belongs_to[1]);
        }

        $id = $builder->insert();

        if (!$id) {
            return null;
        }

        $this->id = $id;

        // many to many automation
        if ($this->_association === 'many_to_many') {
            $this->attach($id);
        }
    }

    public function _update($data = null)
    {

        if ($this->timestamps) {
            $this->updated = date('Y-m-d H:i:s');
        }

        if ($data) {
            $this->loadModelData($data);
        }

        if (method_exists($this, 'beforeUpdate')) {
            $this->beforeUpdate();
        }

        $this->storeUpdate();

        $this->builder->update();

        return $this;
    }

    protected function storeUpdate()
    {

        $this->getBuilder()->where('id', $this->id);

        $this->loadBuilderValues(['updated']);

        $this->builder->update();
    }

    public function _destroy($ids = null)
    {

        if (method_exists($this, 'beforeDestroy')) {
            $this->beforeDestroy();
        }

        if (!$ids) {
            $ids = [$this->id];
        }

        $this->getBuilder()->deleteIds($ids);

        return true;
    }
}
