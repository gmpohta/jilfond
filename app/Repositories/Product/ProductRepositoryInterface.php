<?php

declare(strict_types=1);

namespace App\Repositories\Product;

use App\Dtos\ListDto;
use App\Models\Product;

interface ProductRepositoryInterface
{
    public function list(int $limit, int $page): ListDto;

    public function findOrFail(int $productId): Product;

    public function reserveQuantity(int $productId, int $quantityReduce): int;
}
