<?php

declare(strict_types=1);

namespace App\Services\Cart;

use App\Repositories\Cart\CacheCartRepositoryInterface;
use App\Repositories\Cart\CartRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;

final class AddProductService
{
    private ProductRepositoryInterface $productRepository;

    private CartRepositoryInterface $cartRepository;

    private CacheCartRepositoryInterface $cacheCartRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        CartRepositoryInterface $cartRepository,
        CacheCartRepositoryInterface $cacheCartRepository
    ) {
        $this->productRepository = $productRepository;
        $this->cartRepository = $cartRepository;
        $this->cacheCartRepository = $cacheCartRepository;
    }

    public function __invoke(int $productId, int $quantity, ?int $userId = null): void
    {
        $product = $this->productRepository->findOrFail($productId);

        if (null !== $userId) {
            $this->cartRepository->addProduct($userId, $product->id, $quantity);
        } else {
            $this->cacheCartRepository->addProduct($product->id, $quantity);
        }
    }
}
