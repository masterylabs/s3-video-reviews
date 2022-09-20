<?php

namespace Masteryl\Model;

use Masteryl\Model\Associations\Associate;
use Masteryl\Model\Associations\Attach;
use Masteryl\Model\Associations\BelongsTo;
use Masteryl\Model\Associations\HasMany;
use Masteryl\Model\Associations\HasOne;
use Masteryl\Model\Associations\ManyToMany;
use Masteryl\Model\Called;
use Masteryl\Model\Getters;
use Masteryl\Model\Loaders;
use Masteryl\Model\Operations;
use Masteryl\Model\Parsers;
use Masteryl\Model\Save;
use Masteryl\Model\Search;
use Masteryl\Model\Table;
use Masteryl\Traits\LoadFills;

class Model
{
    use
    LoadFills,
    Associate,
    Attach,
    Table,
    Called,
    Loaders,
    Operations,
    Parsers,
    Save,
    Getters,
    Search,
    ManyToMany,
    HasOne,
    HasMany,
        BelongsTo;

    protected $table;

    protected $fills;

    protected $app;

    protected $query;

    protected $plugin_prefix;

    protected $db_prefix;

    protected $timestamps = true;

    protected $builder;

    protected $default_values;

    protected $pivot_timestamps = 'created';

    protected $identifier_prefix = '';

    protected $identifier_len = 16;

    // protected $format_table_name = true;

    // protected $use_query = true;

    protected $use_identifier = false;

    private static $_apps = [];

    // parsed table

    private $_table;

    private $_pivot_table;

    private $_belongs_to;

    private $_was_called;

    private $_association;

    private $_local_key;

    private $_foreign_key;

    private $_parent;

    private $_hidden;

    private $_json;

    private $_array;

    private $_int;

    private $_float;

    private $_bool;

    private $_wild;

    private $_hidden_values;

    private $_query_params = [
        'limit',
        'offset',
        'page',
        'order',
        'orderby',
    ];

    /**
     * Database values
     */

    private $_db_value = [];

    /**
     * __Constructor
     */

    public function __construct()
    {

        if (!empty(self::$_apps)) {
            $class = get_called_class();
            $ns = explode('\\', $class);
            $this->app = self::$_apps[$ns[0]];
        }

        if (!$this->table) {
            $this->setTableProp();
        }

        // parse fills
        $this->loadFills();

        $this->_table = $this->getTable();
    }

    public static function __callStatic($name, $args = [])
    {
        $model = (new static );

        if (method_exists($model, "_{$name}")) {
            return $model->{"_{$name}"}(...$args);
        }

        return $model->callBuilder($name, $args);
    }

    public function __call($name, $args = [])
    {
        if (method_exists($this, "_{$name}")) {
            return $this->{"_{$name}"}(...$args);
        }

        return $this->callBuilder($name, $args);
    }

    public function __get($key)
    {
        if (isset($this->{$key})) {
            return $this->{$key};
        }

        if ($this->_hidden_values && isset($this->_hidden_values[$key])) {
            return $this->_hidden_values[$key];
        }

        if (method_exists($this, $key)) {

            $res = $this->{$key}();

            if ($res->_association) {

                if (in_array($res->_association, ['belongs_to', 'has_one'])) {
                    return $res->first();
                } elseif (in_array($res->_association, ['has_many', 'belongs_to_many', 'many_to_many'])) {
                    return $res->get();
                }
            }

            // ee($res->_association);
            return $res;
        }
    }

    /**
     * Public
     */

    public static function addApp($app)
    {
        $key = $app->plugin_namespace;
        self::$_apps[$key] = $app;
    }

    /**
     * Private Internals
     */

    public function callBuilder($name, $args)
    {
        if (!$this->builder) {
            $this->loadBuilder();
        }

        $this->builder->{$name}(...$args);

        $method = $name . 'Called';

        if (method_exists($this, $method)) {
            return $this->{$method}();
        }

        return $this;
    }

    public function wasCalled()
    {
        return $this->_was_called ? $this->_was_called : false;
    }

    public function has($key)
    {
        return isset($this->{$key}) && $this->{$key} !== '';
    }
}
