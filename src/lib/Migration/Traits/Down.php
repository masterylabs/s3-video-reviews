<?php

namespace Masteryl\Migration\Traits;

trait Down
{

    public function down()
    {
        $this->dropTable();
    }

    public function dropTable()
    {
        // get me table, force for fresh query
        $table = $this->getTable();

        if (!$this->tableExists($table, true)) {
            return false;
        }

        $dropped = $this->getDb()->query("DROP TABLE {$table}");

        if (!$dropped) {
            $this->error = 'drop_table';
            return false;
        }

        return true;

    }
}
