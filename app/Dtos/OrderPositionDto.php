<?php

declare(strict_types=1);

namespace App\Dtos;

final class OrderPositionDto
{
    public int $quantity;

    public int $productId;

    public function __construct(
        int $productId,
        int $quantity
    ) {
        $this->quantity = $quantity;
        $this->productId = $productId;
    }
}
