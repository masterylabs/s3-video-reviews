<?php
namespace Masteryl\Model\Associations;

use Masteryl\Model\Associations\AssociationHelper;

trait ManyToMany
{

    public function withPivot($cols = [])
    {
        foreach ($cols as $i => $val) {
            $cols[$i] = $this->_pivot_table . '.' . $val;
        };

        $this->getBuilder()->addCols($cols);

        return $this;
    }

    // protected $_local_key;

    // Product::class, 'contact_product', 'contact_id', 'product_id'

    public function manyToMany($class, $pivotTable = false, $localKey = false, $foreignKey = false)
    {

        if (!$pivotTable) {
            $pivotTable = AssociationHelper::pivotTable($this, $class);
        }

        if (!$localKey) {
            $localKey = AssociationHelper::localKey($this);
        }

        if (!$foreignKey) {
            $foreignKey = AssociationHelper::foreignKey($class);
        }

        // Build Class
        $model = new $class();

        $model->_association = 'many_to_many';

        $model->_pivot_table = $pivotTable;

        $model->_foreign_key = [$localKey, $this->id];

        $model->_local_key = $foreignKey;

        $table = $model->getTable();

        $value = [
            "{$pivotTable}.{$localKey}" => $this->id,
            "{$pivotTable}.{$foreignKey}" => "{$table}.id",
        ];

        $model->getBuilder()->innerJoin($pivotTable, $value);

        return $model;
    }

    /**
     * Model Helpers
     */

    // TEMP

    private function getPivotTable($class)
    {
        return AssociationHelper::pivotTable($this, $class);
    }

    // private function getPivotTableV1($foreignModel)
    // {
    //     $arr = [Inflect::singularize($this->table), Inflect::singularize($foreignModel->table)];
    //     sort($arr);

    //     $table = $arr[0] . '_' . $arr[1];

    //     return $this->getTable($table);
    // }
}
