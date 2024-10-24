<?php

declare(strict_types=1);

namespace App\Repositories\Order;

use App\Dtos\OrderPositionDto;
use App\Models\Order;

interface OrderRepositoryInterface
{
    /** @return Order[] */
    public function list(int $userId): array;

    /** @param OrderPositionDto[] $orderPositions */
    public function create(array $orderPositions, int $userId): Order;

    public function delete(Order $order): void;

    public function find(int $orderId): ?Order;
}
