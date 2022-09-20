<?php

namespace Masteryl\QueryBuilder;

trait Methods
{

    public function pivotCols($cols)
    {
        foreach ($cols as $col) {
            $this->cols[] = $this->_pivot_table . '.' . $col;
        }

        return $this;
    }

    public function innerJoin($table, $value = [])
    {
        $this->_pivot_table = $table;

        if (!$this->inner_joins) {
            $this->inner_joins = [];
        }

        $this->inner_joins[$table] = $value;

        return $this;
    }

    /**
     * ADD
     */

    public function addValue($key, $value)
    {
        return $this->addValues([$key => $value]);
    }

    public function addValues($arr)
    {

        foreach ($arr as $key => $val) {
            $this->values[$key] = $val;
        }

        return $this;
    }

    public function addCol($col)
    {
        $this->cols[] = $col;

        return $this;
    }

    public function addCols($cols)
    {
        if (is_array($cols)) {
            $this->cols = array_merge($this->cols, $cols);
        }

        return $this;
    }

    public function setCols($cols)
    {
        $this->cols = $cols;
    }

    /**
     * WHERE
     */
    public function whereIsNull($col, $comp = '=', $del = 'AND')
    {
        $this->where[] = compact('col', null, 'comp', 'del');
    }

    public function where($col, $value = '', $comp = '=', $del = 'AND', $escaped = false)
    {
        if (!$escaped) {
            $value = $this->escape($value);
        }

        // if ($col === 'user_id') {
        //     ee([$value, is_null($value)]);
        // }

        // support array where
        if (is_array($col)) {
            return $this->whereArr($col, $comp, $del);
        }

        // echo "\n where " . $col;

        $this->where[] = compact('col', 'value', 'comp', 'del');

        return $this;
    }

    public function whereLike($col, $value, $comp = 'any', $del = 'OR')
    {

        // support array where
        if (is_array($col)) {
            return $this->whereLikeArr($col, $comp, $del);
        }

        if (strstr($col, '.') == false) {
            $col = $this->table . '.' . $col;
        }

        if ($comp === 'any') {
            $value = '%' . $value . '%';
        } else
        if ($comp === 'start') {
            $value = $value . '%';
        } else
        if ($comp === 'end') {
            $value = '%' . $value;
        }

        $this->where($col, $value, 'LIKE', $del, true);
    }

    public function whereArr($arr, $comp = '=', $del = 'AND')
    {
        foreach ($arr as $key => $val) {
            $this->where($key, $val, $comp, $del);
        }
        return $this;
    }

    public function whereLikeArr($arr, $comp = 'any', $del = 'OR')
    {
        foreach ($arr as $key => $val) {
            $this->where($key, $val, $comp, $del);
        }
        return $this;
    }

    public function clearWhere()
    {
        $this->where = [];

        return $this;
    }
}
