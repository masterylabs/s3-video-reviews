<?php

// Used by migrations

namespace Masteryl\Model;

use Masteryl\Helpers\Inflect;

trait Table
{

    public function getTable($table = false, $format = null)
    {
        if (!$table) {
            $table = !empty($this->table) ? $this->table : $this->setTableProp();
        }

        if (!isset($this->db_prefix) && $this->app->db->prefix) {
            $this->db_prefix = $this->app->db->prefix;
        }

        $customPrefix = $this->app->db_prefix;

        if ($customPrefix) {
            return $this->db_prefix . $customPrefix . $table;
        }

        // Prefixes
        if (!isset($this->plugin_prefix)) {
            $this->plugin_prefix = isset($this->app->db_prefix) ? $this->app->db_prefix : $this->app->id . '_';
        }

        return $this->db_prefix . $this->plugin_prefix . $table;
    }

    public function setTableProp()
    {
        $this->table = $this->getTableProp();
    }

    public function getTableProp()
    {
        $cl = explode('\\', get_called_class());
        return Inflect::pluralize(strtolower(end($cl)));
    }
}
