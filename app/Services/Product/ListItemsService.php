<?php

declare(strict_types=1);

namespace App\Services\Product;

use App\Dtos\ListDto;
use App\Repositories\Product\ProductRepositoryInterface;

final class ListItemsService
{
    private ProductRepositoryInterface $repository;

    public function __construct(ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(int $limit, int $page): ListDto
    {
        return $this->repository->list($page, $limit);
    }
}
