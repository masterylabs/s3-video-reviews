<?php

namespace Masteryl\QueryBuilder;

trait Queries
{
    // update single col

    public function updateCol($col, $value, $id = null)
    {
        if ($id) {
            $query = "UPDATE {$this->table} SET {$col} = " . $this->escape($value, true) . " WHERE id = " . $this->escape($id, true) . " LIMIT 1";
        } else {
            // ee('get id from builder');
        }

        $this->result = $this->db->query($query);

        return empty($this->db->last_error);
    }

    // get single column

    public function getCol($col, $id = null)
    {
        if ($id) {
            $query = "SELECT {$col} FROM {$this->table} WHERE id = '" . $id . "' LIMIT 1";
        } else {
            // ee('get col using own id in where');
        }

        // ee($query);

        $result = $this->db->get_col($query);

        $this->result = !empty($result) ? $result[0] : false;

        return $this->result;
    }

    public function deleteIds($ids)
    {
        foreach ($ids as $id) {
            $query = "DELETE FROM {$this->table} WHERE id=" . $this->escape($id, true) . " LIMIT 1";

            $this->db->query($query);
        }
    }

    public function getIds($key = 'id')
    {
        $this->addCol($key);
        $results = $this->query();

        $value = [];

        if (!empty($results)) {
            foreach ($results as $i) {
                $value[] = $i->{$key};
            }
        }

        $this->result = $value;

        return $value;
    }

    public function delete()
    {

        $query = "DELETE FROM {$this->table}" . $this->appendWHere();

        // ee('delete', $query);
    }

    public function queryQuery($query)
    {
        return $this->db->get_results($query);
    }

    public function query()
    {
        $query = "SELECT " . $this->appendCols() . " FROM {$this->table}";

        $query .= $this->appendInnerJoins();

        $query .= $this->appendWHere();

        $query .= $this->appendOrder();

        $query .= $this->appendLimit();

        // exit($query);

        $this->result = $this->db->get_results($query);

        return $this->result;
    }

    public function appendOrder()
    {

        if (!empty($this->orderby)) {
            $order = !empty($this->order) ? $this->order : 'desc';
            return ' ORDER BY ' . $this->orderby . ' ' . strtoupper($order);
        } elseif (!empty($this->order)) {
            return ' ORDER BY ' . $this->table . '.id ' . strtoupper($order);
        }

        return '';
    }

    public function queryRow()
    {
        $this->limit = 1;

        $result = $this->query();

        $this->result = !empty($result) ? $result[0] : false;

        return $this->result;
    }

    public function update($limit = 1)
    {
        $query = 'UPDATE ' . $this->table . ' SET ';

        foreach ($this->values as $col => $val) {
            $query .= $col . ' = ' . $this->escape($val, true) . ', ';
        }
        $query = rtrim($query, ', ');

        $query .= $this->appendWhere();

        if ($limit) {
            $query .= " LIMIT {$limit}";
        }

        $this->result = $this->db->query($query);

        return empty($this->db->last_error);
    }

    /**
     * Undocumented function
     *
     * @param array[type] $values if value is passed
     * @param string $table, will use builder table by default
     * @return void
     */
    public function insert($values = null, $table = null)
    {
        if (is_array($table)) {
            return $this->insert($table, $values);
        }

        if (!$values) {
            $values = $this->values;
        }

        if (!$table) {
            $table = $this->table;
        }

        $cols = [];
        $vals = [];

        foreach ($values as $key => $val) {
            $cols[] = $key;
            $vals[] = $this->escape($val, true);
        }

        $query = "INSERT INTO {$table} (" . implode(',', $cols) . ") VALUES (" . implode(',', $vals) . ")";

        $success = $this->db->query($query);

        if (!$success) {
            // var_dump($this->db);exit;
        }

        return !empty($this->db->insert_id) ? $this->db->insert_id : false;
    }

    public function count()
    {
        $query = "SELECT COUNT(*) FROM {$this->table}";

        $query .= $this->appendWHere();

        $n = $this->db->get_var($query);

        settype($n, 'int');

        $this->result = $n;

        return $this->result;
    }

    public function find($id, $cols = false)
    {
        $this->where('id', $id);

        if ($cols) {
            $this->addCols($cols);
        }

        return $this->queryRow();
    }

    public function first($cols = null)
    {
        if ($cols) {
            $this->addCols($cols);
        }

        return $this->queryRow();
    }

    /**
     * Privates
     */

    public function appendInnerJoins()
    {
        if (empty($this->inner_joins)) {
            return '';
        }

        $query = ' INNER JOIN';

        foreach ($this->inner_joins as $table => $values) {
            $query .= " {$table} ON";
            $i = 0;
            foreach ($values as $col => $val) {
                if ($i > 0) {
                    $query .= ' AND';
                }
                $query .= ' ' . $col . ' = ' . $val;
                $i++;
            }
        }

        return $query;
    }

    private function appendWHere()
    {
        if (empty($this->where)) {
            return '';
        }

        return $this->whereToQueryString($this->where);
    }

    // Added Group Dels

    private function whereToQueryString($where)
    {
        $query = ' WHERE ';

        $cols = [];

        $lastDel = null;

        foreach ($where as $i => $item) {

            // avoid duplicate entrries
            if (in_array($item['col'], $cols)) {
                continue;
            }

            // ee($item);

            array_push($cols, $item['col']);

            if ($i > 0) {

                if ($lastDel !== $item['del']) {
                    $query .= ') ' . $item['del'] . ' (';
                } else {
                    $query .= " {$item['del']} ";
                }
            } else {
                $query .= '(';
            }

            if (strpos($item['col'], '.') === false) {
                $query .= $this->table . '.';
            }

            $query .= $item['col'] . ' ';
            $val = isset($item['value']) ? $item['value'] : null;

            // ee([$query, $val, is_null($val)]);

            if (is_null($val)) {
                if ($item['comp'] === '!=') {
                    $query .= 'IS NOT NULL';
                } else {
                    $query .= 'IS NULL';
                }
            } else {

                if (!is_numeric($val)) {
                    $val = "'" . $val . "'";
                }

                $query .= $item['comp'] . ' ' . $val;
            }

            $lastDel = $item['del'];
        }

        $query .= ')';

        // ee($query);

        return $query;
    }

    // private function appendSort()
    // {
    //     if($this->orderBy)
    // }

    private function appendLimit()
    {
        // ee($this->limit);
        if (empty($this->limit) || (int) $this->limit < 1) {
            return '';
        }

        $value = ' LIMIT ';

        // use offset

        if ($this->offset) {
            $value .= $this->offset . ', ';
        }

        // use page

        elseif ($this->page && $this->page > 1) {
            $value .= (($this->page - 1) * $this->limit) . ', ';
        }

        $value .= $this->limit;

        return $value;
    }
    // returns id

    private function appendCols()
    {
        if (empty($this->cols)) {
            return ' ' . $this->table . '.*';
        }

        $cols = [];

        foreach ($this->cols as $i) {
            if (strstr($i, '.') == false) {
                $i = $this->table . '.' . $i;
            }
            $cols[] = $i;
        }

        return ' ' . implode(', ', $cols);
    }
}
