<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Создание заказа</title>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
            color: #333;
        }
        .container {
            margin-top: 50px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            margin-bottom: 30px;
            text-align: center;
            color: #007bff;
        }
        h2 {
            margin-bottom: 20px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }
        table {
            width: 100%;
            margin-bottom: 30px;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }
        th {
            background-color: #f1f1f1;
        }
        tr:hover {
            background-color: #f8f9fa;
        }
        h3 {
            text-align: right;
            color: #28a745;
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
        .btn-primary {
            background-color: #007bff;
            color: white;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
        .btn-back {
            background-color: transparent;
            color: #007bff;
            border: 2px solid #007bff;
            margin-right: 10px;
        }
        .btn-back:hover {
            background-color: #007bff;
            color: white;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 5px;
        }
        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
        .button-group {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .auth-container {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }
        .auth-container .btn {
            margin-left: 10px;
        }
        .user-email {
            margin-top: auto;
            margin-bottom: auto;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Оформление заказа</h1>
    
    <div class="auth-container">
        @if(auth()->check())
            <span class="user-email">{{ auth()->user()->email }}</span>
            <a href="{{ route('logout') }}" class="btn btn-secondary">Выйти</a>
        @else
            <a href="{{ route('login') }}" class="btn btn-secondary">Войти</a>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <h2>Ваша корзина</h2>
    @if (count($cart->products) > 0)
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>Товар</th>
                    <th>Цена</th>
                    <th>Количество</th>
                    <th>Итого</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cart->products as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ number_format($item->price, 2) }} ₽</td>
                    <td>{{ $item->pivot->quantity }}</td>
                    <td>{{ number_format($item->price * $item->pivot->quantity, 2) }} ₽</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <h3>Итого: {{ number_format($cart->totalPrice, 2) }} ₽</h3>

        <div class="button-group">
            <a href="{{ route('products') }}" class="btn btn-back">Назад к товарам</a>
            <form action="{{ route('checkout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">Оформить заказ</button>
            </form>
        </div>
    @else
        <p>Ваша корзина пуста.</p>
        <a href="{{ route('products') }}" class="btn btn-secondary">Продолжить покупки</a>
    @endif
</div>
</body>
</html>