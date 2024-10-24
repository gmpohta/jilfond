<?php

declare(strict_types=1);

namespace App\Services\Order;

use App\Dtos\ListOrdersDto;
use App\Models\Order;
use App\Models\Product;
use App\Repositories\Order\OrderRepositoryInterface;

final class ListItemsService
{
    private OrderRepositoryInterface $repository;

    public function __construct(OrderRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(int $userId): ListOrdersDto
    {
        $orders = $this->repository->list($userId);

        $totalPrice = array_sum(array_map(
            static fn(Order $order) => $order->products->sum(
                static fn(Product $product) => $product->price * $product->pivot->quantity,
            ),
            $orders,
        ));

        return new ListOrdersDto($totalPrice, $orders);
    }
}
