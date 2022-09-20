<?php
namespace Masteryl\Model\Associations;

use Masteryl\Model\Associations\AssociationHelper;

trait HasMany
{

    public function hasMany($class, $foreignKey = false, $localKey = 'id')
    {

        if (!$foreignKey) {
            $foreignKey = AssociationHelper::foreignKey($this);
        }

        $model = new $class();

        $model->_association = 'has_many';

        $value = $this->{$localKey};

        $model->getBuilder()->where($foreignKey, $value);

        $model->_belongs_to = [$foreignKey, $value];

        return $model;
    }
}
