<?php

namespace Masteryl\Model\Associations;

trait Associate
{
    public function associate($value)
    {
        if (is_object($value)) {
            $value = $value->id;
        }

        if ($this->_belongs_to) {

            $table = $this->_belongs_to['owner_table'];
            $ownerKey = $this->_belongs_to['owner_key'];
            $ownerValue = $this->_belongs_to['owner_value'];
            $foreignKey = $this->_belongs_to['foreign_key'];

            $data = [
                $foreignKey => $value,
            ];

            $where = [
                $ownerKey => $ownerValue,
            ];

        } else {
            return;
        }

        $this->app->db->update($table, $data, $where);

    }
}
