<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог товаров</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        h1 {
            text-align: center;
            margin-bottom: 40px;
            color: #343a40;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }
        .card {
            border: 1px solid #e0e0e0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card-body {
            padding: 20px;
        }
        .card-title {
            color: #8d9bb3;
            font-size: 1.25rem;
            font-weight: bold;
        }
        .card-text {
            font-size: 1rem;
            margin: 10px 0;
            color: #495057;
        }
        .form-group label {
            font-weight: 600;
            color: #495057;
        }
        .btn-primary {
            background-color: #c4d6f2;
            border-color: #c4d6f2;
            cursor: pointer;
        }
        .quantity-container {
            margin-left: 0;
            padding-left: 0;
            display: flex;
            justify-content: left;
        }
        .quantity-input {
            margin-top: auto;
            margin-bottom: auto;
            margin-right: 5px;
            height: 18px;
            width: fit-content;
            max-width: 50px;
        }
        .pagination {
            font-size: 16px;
            padding-top: 50px;
            padding-bottom: 50px;
            margin: auto;
            width: 100%;
            text-align: center;
        }
        .pagination a {
            text-decoration: none;
            color: #007bff;
            padding: 10px 15px;
            margin: 0 5px;
            border: 1px solid #007bff;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }
        .pagination a.active {
            background-color: #6c757d;
            color: #ffffff;
            border: 1px solid #6c757d;
        }
        .to-order {
            text-align: right;
            padding-bottom: 20px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 10px;
            border: none;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
        .auth-container {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }
        .auth-container .btn {
            margin-left: 10px;
            margin-right: 20px;
        }
        .user-email {
            margin-top: auto;
            margin-bottom: auto;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Каталог товаров</h1>
        
        <div class="auth-container">
            @if(auth()->check())
                <a href="{{ route('orders.index') }}" class="btn btn-primary">Все Заказы</a>
                <span class="user-email">{{ auth()->user()->email }}</span>
                <a href="{{ route('logout') }}" class="btn btn-secondary">Выйти</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-secondary">Войти</a>
            @endif
        </div>

        <div class="to-order">
           <a href="{{ route('cart') }}" class="btn btn-secondary">Оформить заказ</a> 
        </div>
        <div class="grid-container">
            @foreach($products->items as $product)
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">Цена: {{ $product->price }}₽</p>

                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="quantity">Количество:</label>
                                <div class="quantity-container">
                                    <input type="number" name="quantity" id="quantity" class="quantity-input" value="1" min="1" max="{{ $product->quantity }}">
                                    <p>/ {{ $product->quantity }}</p>
                                </div>
                            </div>
                            @if($product->quantity > 0)
                                <button type="submit" class="btn btn-primary mt-2">Добавить в корзину</button>
                            @endif
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="pagination">
        @if($products->pagination['currentPage'] > 1)
            <a href="{{ route('products', ['page' => $products->pagination['currentPage'] - 1]) }}">Назад</a>
        @endif

        @for($i = 1; $i <= $products->pagination['totalPages']; $i++)
            <a href="{{ route('products', ['page' => $i]) }}">{{ $i }}</a>
        @endfor

        @if($products->pagination['currentPage'] < $products->pagination['totalPages'])
            <a href="{{ route('products', ['page' => $products->pagination['currentPage'] + 1]) }}">Вперед</a>
        @endif
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>