<?php

namespace App\Model\Paginator;

use Symfony\Component\HttpFoundation\Request;

class PaginatorFactory
{
    public static function init(Request $request)
    {
        $limit = $request->get('limit', Paginator::DEFAULT_LIMIT);
        $page = $request->get('page', 1);
        $offset = ($page * $limit) - $limit;

        return (new Paginator())
            ->setLimit($limit)
            ->setPage($page)
            ->setOffset($offset);
    }
}
