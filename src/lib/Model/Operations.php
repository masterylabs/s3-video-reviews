<?php
namespace Masteryl\Model;

trait Operations
{
    public function _firstOrCreate($match = [], $data = [])
    {

        $builder = $this->getBuilder()->whereArr($match);

        // check if exists
        $result = $builder->first();

        if ($result) {
            $this->loadResult($result);
            return $this;
        }

        return $this->_create(array_merge($match, $data));
    }

    public function _createOrUpdate($match, $data)
    {

        $builder = $this->getBuilder()->whereArr($match);

        // check if exists
        $result = $builder->first();

        // ee(['_createOrUpdate', $result]);

        if (!$result) {
            return $this->_create(array_merge($match, $data));
        }

        // update
        $this->loadResult($result);

        // ee('update');

        return $this->_update(array_merge($match, $data));

    }
}
