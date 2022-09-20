<?php
namespace Masteryl\Model;

trait Getters
{
    public function getBuilder()
    {
        if (!$this->builder) {
            $this->loadBuilder();
        }
        return $this->builder;
    }

    public function getSearchCols()
    {
        if ($this->search_cols) {
            return $this->search_cols;
        }

        return $this->fills;
    }

    private function getTimestamp()
    {
        return date('Y-m-d H:i:s');
    }
}
