<?php

namespace Masteryl\QueryBuilder;

use Masteryl\QueryBuilder\Methods;
use Masteryl\QueryBuilder\Paginate;
use Masteryl\QueryBuilder\Queries;

class QueryBuilder
{
    use Methods, Paginate, Queries;

    protected $db;

    protected $table;

    protected $cols = [];

    protected $values = [];

    protected $inner_joins = [];

    protected $where = [];

    protected $limit;

    protected $offset;

    protected $page;

    protected $result;

    protected $paginate;

    protected $default_pagin_limit = 24;

    // sorting

    protected $order;

    protected $orderby = 'id';

    // protected $id;

    // can be used to add pivot cols

    private $pivot_table;

    private $callable_props = [
        'db',
        'table',
        'cols',
        'limit',
        'offset',
        'page',
        'result',
        'order',
        'orderby',
    ];

    public function __construct($db, $table)
    {
        $this->db = $db;

        $this->table = $table;
    }

    public function __get($key)
    {
        if (isset($this->{$key})) {
            return $this->{$key};
        }
    }

    // support for set or just prop as function

    public function __call($key, $val)
    {
        // set props with a function
        if (strpos($key, 'set') === 0) {
            $key = strtolower(substr($key, 3));
        }

        if (in_array($key, $this->callable_props)) {
            $this->{$key} = $val[0];
        }

    }

    public function get($cols = null)
    {
        if ($cols) {
            $this->addCols($cols);
        }

        $this->result = $this->query();
    }

    public function getResult()
    {
        return $this->paginate ? $this->getPaginateResult() : $this->result;
    }

    /**
     * Privates
     */

    private function escape($val, $quotes = false)
    {
        $val = $this->db->_real_escape($val);

        if ($quotes && !is_numeric($val)) {
            $val = "'" . $val . "'";
        }

        return $val;
    }

}
