<?php

declare(strict_types=1);

namespace App\Services\Cart;

use App\Dtos\CartDto;
use App\Repositories\Cart\CacheCartRepositoryInterface;
use App\Repositories\Cart\CartRepositoryInterface;

final class ListProductsService
{
    private CartRepositoryInterface $cartRepository;

    private CacheCartRepositoryInterface $cacheCartRepository;

    public function __construct(
        CartRepositoryInterface $cartRepository,
        CacheCartRepositoryInterface $cacheCartRepository
    ) {
        $this->cartRepository = $cartRepository;
        $this->cacheCartRepository = $cacheCartRepository;
    }

    public function __invoke(?int $userId = null): CartDto
    {
        $cart = null;

        if (null !== $userId) {
            $cart = $this->cartRepository->getCart($userId);
        } else {
            $cart = $this->cacheCartRepository->getCart();
        }

        $totalPrice = 0;

        foreach ($cart->products as $cartItem) {
            $totalPrice += $cartItem->price * $cartItem->pivot->quantity;
        }

        return new CartDto(
            $totalPrice,
            $cart->products->all(),
        );
    }
}
