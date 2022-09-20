<?php

namespace Masteryl\Migration\Traits;

trait Update
{
    public function update()
    {
        if ($this->_can_update) {
            $this->updateTable();
        }
    }

    public function alter()
    {
        if ($this->_can_alter) {
            $this->updateTable();
        }
    }

    private function updateTable()
    {
        $table = $this->getTable();

        if (!$this->tableExists($table)) {
            $this->error = 'table_missing';
            return false;
        }

        $cols = $this->builder_cols;

        $existingCols = $this->getCols();

        $query = "ALTER TABLE {$table}";

        foreach ($cols as $col) {
            $values[] = $this->parseCreateColValue($col);
        }

        foreach ($values as $i => $value) {

            $action = in_array($cols[$i]['name'], $existingCols) ? 'MODIFY' : 'ADD';

            $query .= " {$action} {$value}";

            if (!empty($cols[$i]['first'])) {
                $query .= ' FIRST';
            } elseif (!empty($cols[$i]['after'])) {
                $query .= ' AFTER ' . $cols[$i]['after'];
            }
            // else {
            //     // $query .= ' AFTER ' . $lastCol;
            // }
            $query .= ',';
        }

        $query = rtrim($query, ',');

        $updated = $this->getDb()->query($query);

        if (!$updated) {
            $this->error = 'update_table';
            return false;
        }

        // if (!empty($this->conn->mysqli_error)) {
        //     return $this->onError('create_table', $this->conn->mysqli_error);
        // }

        return true;
    }
}
