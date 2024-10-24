<?php

declare(strict_types=1);

namespace App\Services\Order;

use App\Repositories\Order\OrderRepositoryInterface;

final class DeleteService
{
    private OrderRepositoryInterface $repository;

    public function __construct(OrderRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(int $orderId): void
    {
        $order = $this->repository->find($orderId);

        if (null !== $order) {
            $this->repository->delete($order);
        }
    }
}
