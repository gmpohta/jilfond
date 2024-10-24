<?php

declare(strict_types=1);

namespace App\Services\Cart;

use App\Repositories\Cart\CacheCartRepositoryInterface;
use App\Repositories\Cart\CartRepositoryInterface;

final class TransferService
{
    private CacheCartRepositoryInterface $cacheCartRepository;

    private CartRepositoryInterface $cartRepository;

    public function __construct(
        CacheCartRepositoryInterface $cacheCartRepository,
        CartRepositoryInterface $cartRepository
    ) {
        $this->cacheCartRepository = $cacheCartRepository;
        $this->cartRepository = $cartRepository;
    }

    public function __invoke(int $userId)
    {
        $cacheCart = $this->cacheCartRepository->getCart();

        foreach ($cacheCart->products as $cartItem) {
            $this->cartRepository->addProduct($userId, $cartItem->id, $cartItem->pivot->quantity);
        }

        $this->cacheCartRepository->clear();
    }
}
