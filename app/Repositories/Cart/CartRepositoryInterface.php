<?php

declare(strict_types=1);

namespace App\Repositories\Cart;

use App\Models\Cart;

interface CartRepositoryInterface
{
    public function getCart(int $userId): Cart;

    public function addProduct(int $userId, int $productId, int $quantity): void;

    public function clear(int $userId): void;
}
