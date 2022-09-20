<?php

namespace Masteryl\Model\Associations;

use Masteryl\Helpers\Str;

class AssociationHelper
{
    public static function pivotTable($m, $b)
    {
        // support is model is passed in as secondary

        if (is_object($b)) {
            $b = get_class($m);
        }

        $a = explode('\\', get_class($m));
        $a = Str::camelToSnake(end($a));

        $b = explode('\\', $b);
        $b = Str::camelToSnake(end($b));

        $arr = [$a, $b];
        sort($arr);

        $table = $arr[0] . '_' . $arr[1];

        return $m->getTable($table);
    }

    public static function localKey($m)
    {
        $a = explode('\\', get_class($m));
        return Str::camelToSnake(end($a)) . '_id';
    }

    public static function foreignKey($class)
    {
        if (is_object($class)) {
            $class = get_class($class);
        }

        $i = explode('\\', $class);
        return Str::camelToSnake(end($i)) . '_id';
    }
}
