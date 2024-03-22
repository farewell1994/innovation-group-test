<?php

declare(strict_types=1);

namespace App\Services\Paginator;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator as OrmPaginator;
use Symfony\Component\HttpFoundation\RequestStack;

class Paginator implements \JsonSerializable
{
    public const DEFAULT_LIMIT = 10;

    private int $total;

    private int $limit;

    private int $pagesCount;

    private int $currentPage;

    private array $items;

    public function __construct(
        private readonly RequestStack $requestStack
    ) {
    }

    public function paginate(QueryBuilder $query): Paginator
    {
        $this->initParams();
        $paginator = new OrmPaginator($query);

        $paginator
            ->getQuery()
            ->setFirstResult($this->limit * ($this->currentPage - 1))
            ->setMaxResults($this->limit);

        $this->total = $paginator->count();
        $this->pagesCount = (int) ceil($paginator->count() / $paginator->getQuery()->getMaxResults());
        $this->items = $paginator->getQuery()->getResult();

        return $this;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function getPagesCount(): int
    {
        return $this->pagesCount;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function jsonSerialize(): array
    {
        return [
            'items' => $this->getItems(),
            'total' => $this->getTotal(),
            'limit' => $this->getLimit(),
            'pagesCount' => $this->getPagesCount(),
            'currentPage' => $this->getCurrentPage(),
        ];
    }

    private function initParams(): void
    {
        $request = $this->requestStack->getMainRequest();
        $currentPage = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', Paginator::DEFAULT_LIMIT);

        $this->currentPage = ($currentPage > 0) ? $currentPage : 1;
        $this->limit = ($limit > 0) ? $limit : self::DEFAULT_LIMIT;
    }
}
