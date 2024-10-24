<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\Cart\AddProductService;
use App\Services\Cart\ListProductsService;
use Illuminate\Http\Request;

final class CartController extends Controller
{
    private AddProductService $addProductService;

    private ListProductsService $listProductsService;

    public function __construct(
        AddProductService $addProductService,
        ListProductsService $listProductsService
    ) {
        $this->addProductService = $addProductService;
        $this->listProductsService = $listProductsService;
    }

    public function add(Request $request, int $id)
    {
        $quantity = (int) $request->input('quantity', 1);
        $userId = auth()->id();

        ($this->addProductService)($id, $quantity, $userId);

        return redirect()->route('products')->with('success', 'Продукт добавлен в корзину!');
    }

    public function cart()
    {
        $userId = auth()->id();

        $cart = ($this->listProductsService)($userId);

        return view('cart.index', compact('cart'));
    }
}
