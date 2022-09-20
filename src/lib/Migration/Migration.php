<?php

namespace Masteryl\Migration;

// use Masteryl\FileSystem\FileSystem;
use Masteryl\FileSystem\FileSystem;
use Masteryl\Migration\Traits\Builder;
use Masteryl\Migration\Traits\Create;
use Masteryl\Migration\Traits\Down;
use Masteryl\Migration\Traits\Getters;
use Masteryl\Migration\Traits\Parsers;
use Masteryl\Migration\Traits\Update;
use Masteryl\Model\Table;

// include_once __DIR__ . '/../file-system/FileSystem.php';

class Migration
{

    use Table, Builder, Create, Down, Getters, Parsers, Update;

    protected $table;

    // can be disabled or preset. unset will attempt to set automatically

    protected $db_prefix;

    // can be disabled or preset. unset will attempt to set automatically

    protected $app_prefix;

    // OPTIONS

    protected $varchar_max;

    private $app;

    private $_table; // parsed table

    private $_tables;

    private $_cols;

    private $_can_create = true;

    private $_can_update = true;

    private $_can_alter = true;

    public function __construct($app, $options = null)
    {
        $this->app = $app;

        $this->_table = $this->getTable();

        if ($options) {
            foreach ($options as $key => $val) {
                $this->{$key} = $val;
            }
        }

        // if (!isset($this->table)) {
        //     $arr = preg_split('/(?=[A-Z])/', get_called_class());
        //     $name = $arr[count($arr) - 2];
        //     $this->table = strtolower(Inflect::pluralize($name));
        // }
        // ee('migration table', $this->_table);

    }

    public function createOnly()
    {
        $this->_can_create = true;
        $this->_can_update = false;
        $this->_can_alter = false;
        return $this;
    }

    public function updateOnly()
    {
        $this->_can_create = false;
        $this->_can_update = true;
        $this->_can_alter = false;
        return $this;
    }

    public function alterOnly()
    {
        $this->_can_create = false;
        $this->_can_update = false;
        $this->_can_alter = true;
        return $this;
    }

    public function canCreate($value = true)
    {
        $this->_can_create = $value;
        return $this;
    }

    public function canUpdate($value = true)
    {
        $this->_can_update = $value;
        return $this;
    }

    public function canAlter($value = true)
    {
        $this->_can_alter = $value;
        return $this;
    }

    public static function migrateWithOptions($app, $options)
    {
        return self::migrate($app, null, false, false, $options);
    }

    public static function migrate($app, $dir = null, $customNamespace = false, $isModuleDir = false, $options = null)
    {

        // ee('migratewithoptions', $options);

        if (!$dir) {
            $dir = $app->plugin_dir . '/app/Migrations';
        }

        // if (!file_exists($dir)) {
        //     return;
        // }
        $names = FileSystem::getFileNames($dir, true);

        $migrations = [];

        $nsPrefix = $customNamespace ? $customNamespace . '\\' : $app->plugin_namespace . '\\Migrations\\';

        foreach ($names as $name) {
            $className = $nsPrefix . substr($name, 0, -4);

            $class = new $className($app, $options);

            // ee($class->_table);

            $class->createOnly()->up();
            $migrations[] = $class;
        }

        foreach ($migrations as $class) {
            $class->clearBuilder()->updateOnly()->up();
        }

        foreach ($migrations as $class) {
            $class->clearBuilder()->alterOnly()->up();
        }

        if (!$isModuleDir && $app->modules) {

            foreach ($app->modules as $mod) {

                // migrations dir

                $dir = $mod['dir'] . '/Migrations';

                if (file_exists($dir)) {
                    $ns = $app->getModuleNamespace($mod['name'], '\\Migrations');
                    self::migrate($app, $dir, $ns, true, $options);
                }

            }
        }

    }

    public function rollback($dir = null)
    {
        $app = $this->app;

        if (!$dir) {
            $dir = $app->plugin_dir . '/app/Migrations';
        }

        $names = FileSystem::getFileNames($dir, true);

        foreach ($names as $name) {
            $className = $app->plugin_namespace . '\\Migrations\\' . substr($name, 0, -4);
            $class = new $className($app);
            $class->down();
        }
    }

}
