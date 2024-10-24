<?php

namespace App\Providers;

use App\Repositories\Cart\CacheCartRepositoryInterface;
use App\Repositories\Cart\CartRepositoryInterface;
use App\Repositories\Cart\InMemoryCartRepository;
use App\Repositories\Cart\PostgresCartRepository;
use App\Repositories\Order\OrderRepository;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(CartRepositoryInterface::class, PostgresCartRepository::class);
        $this->app->bind(CacheCartRepositoryInterface::class, InMemoryCartRepository::class);
    }

    public function boot() {}
}
