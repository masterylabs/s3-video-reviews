<?php
namespace Masteryl\Model\Associations;

use Masteryl\Helpers\Inflect;

trait Attach
{
    public function attachOnce($value, $data = null)
    {
        return $this->attach($value, $data, true);
    }

    public function attach($value, $data = null, $checkIfExists = false)
    {
        if (is_array($value)) {
            foreach ($value as $i) {
                $this->attach($i, $data);
            }
            return $this;
        }

        if (is_object($value)) {
            $value = $value->id;
        }

        // ee($this->_association);

        // if ($this->_association === 'belongs_to') {
        //     $this->_parent->getBuilder()->updateCol($this->_local_key, $value, $this->_parent->id);
        //     return $this;
        // }

        $localKey = $this->_local_key;

        $foreignKey = $this->_foreign_key[0];
        $foreignValue = $this->_foreign_key[1];
        $table = $this->_pivot_table;

        /**
         * Check if esxists
         */
        if ($checkIfExists) {
            $query = "SELECT id FROM {$table} WHERE {$foreignKey} = {$foreignValue} AND {$localKey} = {$value} LIMIT 1";
            $result = $this->app->db->get_col($query);

            if (!empty($result)) {
                return $this;
            }
        }

        $values = [
            $foreignKey => $foreignValue,
            $localKey => $value,
        ];

        if ($this->pivot_timestamps) {
            $ts = $this->getTimestamp();

            if (is_string($this->pivot_timestamps)) {
                $key = $this->pivot_timestamps;
                $values[$key] = $ts;
            } elseif (is_bool($this->pivot_timestamps)) {
                $values['created'] = $ts;
                $values['updated'] = $ts;
            } elseif (is_array($this->pivot_timestamps)) {
                foreach ($this->pivot_timestamps as $i) {
                    $values[$i] = $ts;
                }
            }

        }

        if ($data) {
            $values = array_merge($values, $data);
        }

        $this->app->db->insert($table, $values);

        return $this;

    }

    public function detach($value = null)
    {
        if (is_array($value)) {
            foreach ($value as $i) {
                $this->detach($i);
            }
            return $this;
        }

        if (is_object($value)) {
            $value = $value->id;
        }

        if ($this->_association === 'belongs_to') {
            $this->_parent->getBuilder()->updateCol($this->_local_key, null, $this->_parent->id);
            return $this;
        }

        $foreignKey = $this->_foreign_key;
        $table = $this->_pivot_table;

        $localKey = Inflect::singularize($this->table) . '_id';

        $values = [
            $foreignKey[0] => $foreignKey[1],
            $localKey => $value,
        ];

        // ee('deatch', $values);

        $this->app->db->delete($table, $values);

        return $this;
    }

}
