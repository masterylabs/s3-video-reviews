<?php

namespace Masteryl\Migration\Traits;

trait Create
{
    private $_tables;

    public function create()
    {
        if ($this->_can_create) {
            $this->createTable();
        }
    }

    public function db()
    {
        return $this->app->db;
    }

    private function createTable()
    {

        $table = $this->getTable();

        $cols = $this->builder_cols;

        $args = $this->builder_args;

        if ($this->tableExists($table)) {
            $this->error = 'table_exists';
            return false;
        }

        // Create Table
        $query = "CREATE TABLE {$table}";

        $values = [];

        $indexes = [];

        foreach ($cols as $col) {
            $values[] = $this->parseCreateColValue($col);

            // ee([$col, $values]);
            if (!empty($col['index'])) {
                if (!empty($col['index_length'])) {
                    $indexes[] = $col['name'] . '(' . $col['index_length'] . ')';
                } else {
                    $indexes[] = $col['name'];
                }
            }

        }

        if (!empty($indexes)) {
            $values[] = 'INDEX (' . implode(',', $indexes) . ')';
        }

        if (!empty($args['foreign_key_constraints'])) {
            $values[] = $this->parseCreateForeignKeyConstraints($args['foreign_key_constraints'], $table);
        }

        $query .= ' (' . implode(', ', $values) . ')';

        $query .= " DEFAULT CHARACTER SET " . $this->getCharset();

        $query .= " COLLATE " . $this->getCollate();

        $created = $this->getDb()->query($query);

        if (!$created) {
            $this->error = 'create_table';
            return false;
        }

        return true;

    }

}
