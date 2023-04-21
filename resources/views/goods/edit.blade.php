@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <div class="mt-6 mb-4">
            <h2 class="text-lg font-semibold">Редактировать товар {{$goods->product_name}}</h2>
        </div>
        <form method="POST" action="{{ route('goods.update', [$goods]) }}">
        @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block font-medium text-gray-700 mb-2">Название</label>
                <input type="text" class="form-input rounded-md shadow-sm block w-full @error('name') border-red-500 @enderror" id="name" name="name" value="{{ $goods->product_name }}" required autofocus>
                @error('name')
                <span class="text-red-500 mt-1 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="price" class="block font-medium text-gray-700 mb-2">Цена</label>
                <input type="text" class="form-input rounded-md shadow-sm block w-full @error('price') border-red-500 @enderror" id="price" name="price" value="{{ $goods->product_price }}" required>
                @error('price')
                <span class="text-red-500 mt-1 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Сохранить
                </button>
                <a href="{{ route('goods.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
                    <span>Отмена</span>
                </a>
            </div>
        </form>
    </div>
@endsection
