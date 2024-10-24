<?php

declare(strict_types=1);

namespace App\Repositories\Order;

use App\Dtos\OrderPositionDto;
use App\Models\Order;

final class OrderRepository implements OrderRepositoryInterface
{
    /** @return Order[] */
    public function list(int $userId): array
    {
        return Order::with('products')
            ->where('user_id', $userId)
            ->get()
            ->all();
    }

    /** @param OrderPositionDto[] $orderPositions */
    public function create(array $orderPositions, int $userId): Order
    {
        $order = new Order();
        $order->user_id = $userId;

        $order->save();

        foreach ($orderPositions as $orderPosition) {
            $order->products()->attach($orderPosition->productId, ['quantity' => $orderPosition->quantity]);
        }

        return $order;
    }

    public function delete(Order $order): void
    {
        $order->delete();
    }

    public function find(int $orderId): ?Order
    {
        return Order::find($orderId);
    }
}
