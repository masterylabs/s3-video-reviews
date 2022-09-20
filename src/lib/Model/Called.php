<?php
namespace Masteryl\Model;

/*
Called after builder
 */

trait Called
{

    private function findCalled()
    {
        $this->_was_called = 'find';

        return $this->firstCalled();
    }

    private function firstCalled()
    {
        $this->_was_called = 'first';

        $result = $this->builder->getResult();

        if (!$result) {
            return null;
        }

        $this->loadResult($result);

        return $this;
    }

    private function getCalled()
    {
        $this->_was_called = 'get';

        $result = $this->builder->getResult();

        return $this->unparseResults($result);
    }

    private function countCalled()
    {

        $this->_was_called = 'count';

        return $this->builder->getResult();
    }

    private function getIdsCalled()
    {
        return $this->builder->result;
    }

    // private function loadResult($item)
    // {
    //     foreach ($item as $key => $val) {
    //         $this->{$key} = $val;
    //     }
    // }
}
