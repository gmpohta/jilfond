<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\Product\ListItemsService;
use Illuminate\Http\Request;

final class ProductController extends Controller
{
    private ListItemsService $listService;

    public function __construct(ListItemsService $listService)
    {
        $this->listService = $listService;
    }

    public function index(Request $request)
    {
        $limit = (int) $request->get('limit', 10);
        $page = (int) $request->get('page', 1);

        $products = ($this->listService)($page, $limit);

        return view('products.index', compact('products'));
    }
}
