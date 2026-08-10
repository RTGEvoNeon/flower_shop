@extends('layouts.app')

@section('content')
<section class="max-w-3xl mx-auto px-6 lg:px-8 py-24 lg:py-32 text-center">
    <div class="space-y-6">
        <div class="text-6xl">🌸</div>

        <h1 class="font-display text-3xl lg:text-4xl font-bold text-gray-900">
            Спасибо! Мы обрабатываем вашу оплату
        </h1>

        <p class="text-lg text-gray-600 leading-relaxed">
            Как только банк подтвердит платёж, мы получим уведомление и приступим к сборке заказа.
            Если оплата прошла успешно, статус заказа обновится автоматически — можно закрыть эту страницу.
        </p>

        <a href="{{ route('home') }}" class="inline-flex items-center gap-3 px-8 py-4 bg-primary-600 text-white rounded-full font-semibold shadow-xl hover:shadow-2xl hover:scale-105 transition-all">
            <span>Вернуться на главную</span>
        </a>
    </div>
</section>
@endsection
