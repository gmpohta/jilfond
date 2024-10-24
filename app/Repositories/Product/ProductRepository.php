<?php

declare(strict_types=1);

namespace App\Repositories\Product;

use App\Dtos\ListDto;
use App\Models\Product;

final class ProductRepository implements ProductRepositoryInterface
{
    public function list(int $limit, int $page): ListDto
    {
        $offset = ($page - 1) * $limit;
        $count = Product::count();

        return new ListDto(
            Product::skip($offset)->take($limit)->get()->all(),
            [
                'totalItems' => $count,
                'itemsPerPage' => $limit,
                'totalPages' => (int) ceil($count / $limit),
                'currentPage' => $page,
            ],
        );
    }

    public function findOrFail(int $productId): Product
    {
        return Product::findOrFail($productId);
    }

    public function reserveQuantity(int $productId, int $quantityReduce): int
    {
        $product = Product::findOrFail($productId);
        $factQuantity = min($product->quantity, $quantityReduce);

        $product->quantity -= $factQuantity;
        $product->update();

        return $factQuantity;
    }
}
