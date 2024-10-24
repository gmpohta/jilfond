<?php

declare(strict_types=1);

namespace App\Repositories\Cart;

use App\Models\Cart;

final class PostgresCartRepository implements CartRepositoryInterface
{
    public function getCart(int $userId): Cart
    {
        $cart = Cart::where('user_id', $userId)
            ->get()
            ->first();

        if (null === $cart) {
            $cart = new Cart();
            $cart->user_id = $userId;
            $cart->save();
        }

        return $cart;
    }

    public function addProduct(int $userId, int $productId, int $quantity): void
    {
        $cart = Cart::with('products')
            ->where('user_id', $userId)
            ->first();

        if (null === $cart) {
            $cart = Cart::create(['user_id' => $userId]);
        }

        $existingProduct = $cart->products()->where('product_id', $productId)->first();

        if ($existingProduct) {
            $newQuantity = $existingProduct->pivot->quantity + $quantity;
            $cart->products()->updateExistingPivot($productId, ['quantity' => $newQuantity]);
        } else {
            $cart->products()->attach($productId, ['quantity' => $quantity]);
        }
    }

    public function clear(int $userId): void
    {
        $cart = Cart::with('products')
            ->where('user_id', $userId)
            ->first();

        $cart->delete();
    }
}
