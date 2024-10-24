<?php

declare(strict_types=1);

namespace App\Dtos;

use App\Models\Order;

final class ListOrdersDto
{
    public float $totalPrice;

    /** @var Order[] */
    public array $orders;

    public function __construct(
        float $totalPrice,
        /** @var Order[] */
        array $orders
    ) {
        $this->totalPrice = $totalPrice;
        $this->orders = $orders;
    }
}
