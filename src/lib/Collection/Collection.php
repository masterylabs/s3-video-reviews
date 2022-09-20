<?php

namespace Masteryl\Collection;

class Collection
{
    protected $app;

    protected $req;

    protected $res;

    protected $model;

    protected $limit = 10;

    protected $can_index = true;

    protected $can_show = true;

    protected $can_update = true;

    protected $can_delete = true;

    protected $can_query_fills = true;

    protected $is_sub;

    protected $item;
    // value that is set before display

    protected $response;

    // used in teams via event
    protected $user_id;

    private $is_sub_singular;

    public function __construct($req, $res)
    {
        $app = $req->app;

        $this->app = $app;

        $this->req = $req;

        $this->res = $res;

        $class = $this->getModel();

        $this->model = new $class();

        if ($req->id) {
            $this->model->id($req->id);
        }

        $app->call('collection', $this);

    }

    public function __call($name, $args)
    {
        $i = explode('_', $name);

        $modelMethod = $i[0];
        $collMethod = $i[1];

        // $this->is_sub

        $this->model = $this->model->{$modelMethod}();

        if ($this->model->_association && in_array($this->model->_association, ['has_one', 'belongs_to'])) {
            $this->is_sub_singular = true;
        }

        return $this->{$collMethod}($this->req, $this->res);
    }

    public function getProp($key, $na = null)
    {
        return isset($this->{$key}) ? $this->{$key} : $na;
    }

    public function setProp($key, $value)
    {
        $this->{$key} = $value;
    }

    public function index($req, $res)
    {
        if (!$this->can_index) {
            return $res->notAllowed();
        }

        if ($this->user_id) {
            $this->model->where('user_id', $this->user_id);
        }

        $this->model->_queryParams($req);

        // query cols
        if ($this->can_query_fills) {
            $queryFills = is_bool($this->can_query_fills) ? $this->model->fills : $this->can_query_fills;
            foreach ($queryFills as $key) {
                if (!empty($req->{$key})) {
                    $this->model->where($key, $req->{$key});
                }
            }
        }

        // support singular sub collections
        if ($this->is_sub_singular) {
            return $res->data($this->model->first());
        }

        $limit = !empty($req->limit) ? $req->limit : $this->limit;

        if (method_exists($this, 'beforeIndexQuery')) {
            $this->beforeIndexQuery();
        }

        $data = $this->model
            ->paginate($limit)
            ->get();

        return $res->json($data);
    }

    public function create($req, $res)
    {
        // was called and does not exist

        if (!$this->model) {
            ee('model does not exist');
        }

        // support singular sub collection
        if ($this->is_sub_singular) {
            // could make sure parent_id is in builder for CREATE
            $this->model->save($req);

            return $res->data($this->model);
        }

        // standard operation
        if ($this->user_id) {
            $req->user_id = $this->user_id;
        }

        $item = $this->model->create($req);

        return $res->data($item);
    }

    private function queryItem($req)
    {
        if (is_numeric($req->id)) {
            $queryKey = 'id';
        } else {
            $queryKey = 'identifier';
        }

        $query = $this->model->where($queryKey, $req->id);

        if ($this->user_id) {
            $query->where('user_id', $this->user_id);
        }

        return $query->first();
    }

    public function show($req, $res)
    {
        if (!$this->can_show) {
            return $res->notAllowed();
        }

        $this->item = $this->queryItem($req);

        if (!$this->item) {
            return $res->notFound();
        }

        $this->response = [
            'data' => $this->item,
        ];

        if (method_exists($this, 'beforeShow')) {
            $this->beforeShow();
        }

        return $res->json($this->response);
    }

    public function update($req, $res)
    {

        if (!$this->can_update) {
            return $res->notAllowed();
        }

        $item = $this->queryItem($req);

        if (!$item) {
            return $res->notFound();
        }

        $item->update($req);

        return $res->json(['data' => $item, 'message' => 'updated!']);
    }

    public function destroy($req, $res)
    {
        if (!$this->can_show) {
            return $res->notAllowed();
        }

        $item = $item = $this->queryItem($req);

        if (!$item) {
            return $res->notFound();
        }
        $item->destroy();

        return $res->success('Deleted!');
    }
}
