<?php

namespace App\Model\Paginator;

class Paginator
{
    public const DEFAULT_LIMIT = 10;

    private int $page;

    private int $limit;

    private int $offset;

    public function getPage(): int
    {
        return $this->page;
    }

    public function setPage(int $page): Paginator
    {
        $this->page = $page;

        return $this;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function setLimit(int $limit): Paginator
    {
        $this->limit = $limit;

        return $this;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }

    public function setOffset(int $offset): Paginator
    {
        $this->offset = $offset;

        return $this;
    }
}
