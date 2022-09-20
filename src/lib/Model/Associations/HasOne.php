<?php
namespace Masteryl\Model\Associations;

use Masteryl\Model\Associations\AssociationHelper;

trait HasOne
{

    public function hasOne($class, $foreignKey = false, $localKey = 'id')
    {

        if (!$foreignKey) {
            $foreignKey = AssociationHelper::foreignKey($this);
        }

        $model = new $class();

        $model->_association = 'has_one';

        $value = $this->{$localKey};

        // $model->_local_key = [$foreignKey, $value];

        $model->_belongs_to = [$foreignKey, $value];

        $model->getBuilder()->where($foreignKey, $value);

        return $model;
    }

    protected function hasOneBeforeCreate()
    {

    }
}
