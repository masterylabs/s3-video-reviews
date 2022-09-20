<?php

namespace Masteryl\QueryBuilder;

trait Paginate
{

    public function paginate($n = 0)
    {
        $this->paginate = true;

        if ($n > 0) {
            $this->limit = $n;
        } elseif (!$this->limit) {
            $this->limit = $this->default_pagin_limit;
        }

    }

    public function getPaginateResult()
    {
        // requires limit
        if (!$this->limit) {
            return false;
        }

        $data = $this->result;
        $total = $this->count();

        $page = $this->getPage();

        if ($total < 1) {
            $pages = 1;
        } else {
            $pages = ceil($total / $this->limit);
        }

        return [
            'data' => $data,
            'pagin' => [
                'total' => $total,
                'page' => (int) $page, // d
                'pages' => (int) $pages,
                'perpage' => (int) $this->limit,
                'more' => $page < $pages,
            ],
        ];
    }

    private function getPage()
    {
        if ($this->page) {
            return $this->page;
        }

        if ($this->offset && $this->limit) {
            return ceil($this->limit / $this->offset);
        }

        return 1;
    }
}
