<?php

namespace Masteryl\Model;

trait Search
{
    // array or object

    // public function _req($req)
    // {
    //     return $this->_queryParams($req);
    // }

    public function _queryParams($req)
    {
        // return $this;

        $builder = $this->getBuilder();

        // ee($this->_query_params);

        foreach ($req as $key => $val) {

            if ($key === 'search' || $key === 'q') {

                if ($val === '') {
                    continue;
                }
                // ee([$val, $req->search_keys]);
                // ee([$key, $val]);
                $this->_search($val, $req->search_keys);
                continue;
            }

            if (empty($val) || !in_array($key, $this->_query_params)) {
                continue;
            }

            $builder->{$key}($val);
        }

        // fields as cols
        if (!empty($req->fields)) {
            $builder->setCols(explode(',', $req->fields));
        }

        return $this;
    }

    public function _search($keyword, $cols = '', $type = 'any')
    {
        // ee(['search', $cols]);

        if (is_string($cols) && !empty($cols)) {
            if (strstr($cols, ',') === true) {
                $cols = explode(',', $cols);
            } else {
                $cols = [$cols];
            }
        } elseif (empty($cols)) {
            $cols = $this->getSearchCols();
        }

        // ee('seachCols', $cols);

        $builder = $this->getBuilder();

        foreach ($cols as $col) {

            $builder->whereLike($col, $keyword, $type);
            // echo "\nwhereLike: {$col}, {$keyword}, {$type} ";
        }

        return $this;
    }

    // Helper functions

    public function _startsWith($keyword, $cols = '')
    {
        return $this->_search($keyword, $cols, 'start');
    }

    public function _endsWith($keyword, $cols = '')
    {
        return $this->_search($keyword, $cols, 'end');
    }
}
