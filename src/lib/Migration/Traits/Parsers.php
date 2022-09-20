<?php

namespace Masteryl\Migration\Traits;

trait Parsers
{

    /**
     * Private Helpers
     */

    private function parseCreateForeignKeyConstraints($items, $currentTable)
    {
        $values = [];

        foreach ($items as $item) {
            $table = isset($item['table']) ? $this->getTable($item['table']) : $currentTable;
            $values[] = "FOREIGN KEY ({$item['foreign_key']}) REFERENCES {$table}({$item['references']})";
        }

        return implode(',', $values);
    }

    private function parseCreateColValue($col)
    {
        $str = $col['name'] . ' ' . strtoupper($col['type']);
        if (isset($col['length'])) {
            $str .= "({$col['length']}) ";
        } else {
            $str .= ' ';
        }

        if (isset($col['default_value'])) {
            $str .= 'DEFAULT ';
            $i = $col['default_value'];
            if (is_string($i)) {
                $str .= "'" . $i . "' ";
            } else {
                $str .= $i . ' ';
            }
        }

        foreach (['unique', 'auto_increment', 'unsigned'] as $i) {
            if (!empty($col[$i])) {
                $str .= strtoupper($i) . ' ';
            }
        }

        foreach (['primary_key', 'not_null'] as $i) {
            if (!empty($col[$i])) {
                $str .= str_replace('_', ' ', strtoupper($i)) . ' ';
            }
        }

        return rtrim($str, ' ');
    }
}
