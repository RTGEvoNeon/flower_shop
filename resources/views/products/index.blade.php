<!DOCTYPE html>
<html>
<head>
    <title>Цветочный магазин</title>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .products { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; }
        .product { border: 1px solid #ddd; padding: 15px; border-radius: 5px; }
        .product h3 { margin: 0 0 10px 0; }
        .price { font-size: 18px; font-weight: bold; color: #e74c3c; }
    </style>
</head>
<body>
<h1>Каталог букетов</h1>

<div class="products">
    @foreach($products as $product)
        <div class="product">
            <h3>{{ $product->name }}</h3>
            <p>{{ $product->description }}</p>
            <div class="price">{{ number_format($product->price, 0) }} руб.</div>
            <p>Категория: {{ $product->category }}</p>
        </div>
    @endforeach
</div>
</body>
</html>
