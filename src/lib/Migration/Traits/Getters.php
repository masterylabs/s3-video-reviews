<?php

namespace Masteryl\Migration\Traits;

trait Getters
{

    public function tableExists($table = null, $force = false)
    {
        if (!$table) {
            $table = $this->getTable();
        }

        $tables = $this->getTables($force);

        return in_array($table, $tables) == true;
    }

    /**
     * Getters
     */

    public function getDb()
    {
        return $this->app->db;
    }

    // public function getTable()
    // {
    //     if (isset($this->_table)) {
    //         return $this->_table;
    //     }

    //     $table = $this->table;

    //     // set app prefix

    //     $app = $this->app;

    //     if ($this->app_prefix) {
    //         $table = $this->app_prefix . $table;
    //     } elseif (!isset($this->app_prefix) && $app->db_prefix) {

    //         $table = $app->db_prefix . $table;

    //     }

    //     $db = $this->getDb();

    //     if ($this->db_prefix) {
    //         $table = $this->db_prefix . $table;
    //     } elseif (!isset($this->db_prefix) && !empty($db->prefix)) {
    //         $table = $db->prefix . $table;

    //     }

    //     $this->_table = $table;

    //     return $this->_table;

    // }

    public function getTables($force = false)
    {
        if (!isset($this->_tables) || $force) {
            $this->_tables = [];

            $items = $this->getDb()->get_col("SHOW TABLES");

            if ($items) {
                $this->_tables = $items;
            }

        }
        return $this->_tables;
    }

    private function getCols($force = false)
    {
        if (!isset($this->_cols) || $force) {
            $this->_cols = [];

            $table = $this->getTable();

            $items = $this->getDb()->get_col("SHOW COLUMNS FROM {$table}");

            if ($items) {
                $this->_cols = $items;
            }

        }
        return $this->_cols;
    }
    // }

    //     $table = $this->getTable();

    //     $items = $this->getDb()->get_col("SHOW COLUMNS FROM {$table}");

    //     ee('getCols', $items);

    //     $cols = $this->fetchAll();

    //     $this->freeResult();

    //     return $withDetails ? $cols : $this->arrayCompact($cols);

    // }

    /**
     * First looks in db, then in app config for db_charset
     */
    private function getCharset()
    {

        $db = $this->getDb();

        if (!empty($db->charset)) {
            return $db->charset;
        } elseif ($this->app->db_charset) {
            return $this->app->db_charset;
        }

        return 'utf8mb4';
    }

    /**
     * First looks in db, then in app config for db_charset
     */
    private function getCollate()
    {

        $db = $this->getDb();

        if (!empty($db->collate)) {
            return $db->collate;
        } elseif ($this->app->db_collate) {
            return $this->app->db_collate;
        }

        return 'utf8mb4';
    }
}
