<?php

declare(strict_types=1);

namespace App\Dtos;

final class CartDto
{
    public float $totalPrice;

    public array $products;

    public function __construct(
        float $totalPrice,
        array $products
    ) {
        $this->totalPrice = $totalPrice;
        $this->products = $products;
    }
}
