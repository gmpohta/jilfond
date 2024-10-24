<?php

declare(strict_types=1);

namespace App\Repositories\Cart;

use App\Models\Cart;

interface CacheCartRepositoryInterface
{
    public function getCart(): Cart;

    public function addProduct(int $productId, int $quantity): void;

    public function clear(): void;
}
