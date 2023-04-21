@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700" href="{{route('orders.index')}}">Заказы</a>
            <a class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700" href="{{route('goods.index')}}">Товары</a>
            <a class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700" href="{{ route('generate-token') }}">
                {{ __('Генерировать API токен') }}
            </a>
        </div>
    </div>
@endsection
