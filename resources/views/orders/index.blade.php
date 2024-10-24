<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Все Заказы</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .container {
            margin-top: 50px;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #343a40;
            margin-bottom: 20px;
        }

        .alert {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            margin-bottom: 20px;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        th, td {
            text-align: center;
            padding: 10px;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .btn-danger {
            transition: background-color 0.3s, color 0.3s;
        }

        .btn-danger:hover {
            background-color: #c82333;
            color: white;
        }

        h3 {
            margin-top: 20px;
            color: #28a745;
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
    </style>
</head>
<body>
<div class="container">
    <h1>Все Заказы</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Номер заказа</th>
                <th>Дата заказа</th>
                <th>Товары</th>
                <th>Общая стоимость</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach($listOrders->orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                    <td>
                        {{ $order->products->pluck('name')->implode(', ') }}
                    </td>
                    <td>
                        {{ $order->products->sum(function ($product) use ($order) {
                            return $product->price * $product->pivot->quantity;
                        }) }} ₽
                    </td>
                    <td>
                        <form action="{{ route('orders.delete', $order->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Удалить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Итоговая стоимость всех заказов: {{ $listOrders->totalPrice }} ₽</h3>
    <a href="{{ route('products') }}" class="btn btn-back">Назад к товарам</a>
</div>

</body>
</html>