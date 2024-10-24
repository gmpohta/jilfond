<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\Order\CreateService;
use App\Services\Order\DeleteService;
use App\Services\Order\ListItemsService;
use Illuminate\Http\Request;

final class OrderController extends Controller
{
    private DeleteService $deleteService;

    private CreateService $createService;

    private ListItemsService $listService;

    public function __construct(
        DeleteService $deleteService,
        CreateService $createService,
        ListItemsService $listService
    ) {
        $this->deleteService = $deleteService;
        $this->createService = $createService;
        $this->listService = $listService;
    }

    public function checkout()
    {
        $userId = auth()->id();

        ($this->createService)($userId);

        return redirect()->route('orders.index')->with('success', 'Заказ успешно оформлен!');
    }

    public function index()
    {
        $userId = auth()->id();

        $listOrders = ($this->listService)($userId);

        return view('orders.index', compact('listOrders'));
    }

    public function delete(Request $request, int $id)
    {
        ($this->deleteService)($id);

        return redirect()->route('orders.index')->with('success', 'Заказ успешно удален');
    }
}
