<?php
namespace Masteryl\Model\Associations;

use Masteryl\Model\Associations\AssociationHelper;

trait BelongsTo
{
    private $_belongs_to;

    public function belongsTo($class, $foreignKey = false, $ownerKey = 'id')
    {

        if (!$foreignKey) {
            $foreignKey = AssociationHelper::foreignKey($class);
        }

        $ownerValue = $this->{$ownerKey};

        if (!$this->{$foreignKey}) {
            $this->{$foreignKey} = $this->getBuilder()->getCol($foreignKey, $ownerValue);
        }

        $model = new $class();

        $model->_association = 'has_one';

        $value = $this->{$foreignKey};

        $model->getBuilder()->where($ownerKey, $value);

        $model->_belongs_to = [
            'owner_table' => $this->_table,
            'owner_key' => $ownerKey,
            'owner_value' => $ownerValue,
            'foreign_key' => $foreignKey,
        ];

        return $model;
    }

    public function belongsToMany($class, $foreignKey = false, $ownerKey = 'id')
    {

        if (!$foreignKey) {
            $foreignKey = AssociationHelper::foreignKey($class);
        }

        if (!$this->{$foreignKey}) {
            $this->{$foreignKey} = $this->getBuilder()->getCol($foreignKey, $this->id);
        }

        $model = new $class();

        $model->_association = 'has_one';

        $value = $this->{$foreignKey};

        $model->getBuilder()->where($ownerKey, $value);

        return $model;
    }

}
