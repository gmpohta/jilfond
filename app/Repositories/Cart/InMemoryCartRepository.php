<?php

declare(strict_types=1);

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

final class InMemoryCartRepository implements CacheCartRepositoryInterface
{
    public function getCart(): Cart
    {
        $cartData = session()->get('cart', []);

        $cart = new Cart();
        $cart->products = new Collection();

        foreach ($cartData as $productId => $item) {
            $product = Product::find($productId);

            if ($product) {
                $cart->products->push((object) [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'pivot' => (object) ['quantity' => $item['quantity']],
                ]);
            }
        }

        return $cart;
    }

    public function addProduct(int $productId, int $quantity): void
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'quantity' => $quantity,
            ];
        }

        session()->put('cart', $cart);
    }

    public function clear(): void
    {
        session()->forget('cart');
    }
}
