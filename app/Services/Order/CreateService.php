<?php

declare(strict_types=1);

namespace App\Services\Order;

use App\Dtos\OrderPositionDto;
use App\Repositories\Cart\CartRepositoryInterface;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;

final class CreateService
{
    private OrderRepositoryInterface $repository;

    private ProductRepositoryInterface $productRepository;

    private CartRepositoryInterface $cartRepository;

    public function __construct(
        OrderRepositoryInterface $repository,
        CartRepositoryInterface $cartRepository,
        ProductRepositoryInterface $productRepository
    ) {
        $this->repository = $repository;
        $this->cartRepository = $cartRepository;
        $this->productRepository = $productRepository;
    }

    public function __invoke(int $userId): void
    {
        $cart = $this->cartRepository->getCart($userId);
        $orderPositions = [];

        // Нужно сделать оптимистичную блокировку
        foreach ($cart->products as $cartItem) {
            $factQuantity = $this->productRepository->reserveQuantity($cartItem->id, $cartItem->pivot->quantity);
            $orderPositions[] = new OrderPositionDto($cartItem->id, $factQuantity);
        }

        $this->repository->create($orderPositions, $userId);

        $this->cartRepository->clear($userId);
    }
}
