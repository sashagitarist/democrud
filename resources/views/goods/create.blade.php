@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <div class="flex justify-center">
            <div class="w-full max-w-md">
                <div class="bg-white p-6 rounded-lg">
                    <div class="text-gray-800 font-medium text-lg mb-4">{{ __('Добавить товар') }}</div>
                    <form method="POST" action="{{ route('goods.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 font-medium mb-2">{{ __('Название') }}</label>

                            <input id="name" type="text" class="form-input rounded-md shadow-sm @error('name') border-red-500 @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="price" class="block text-gray-700 font-medium mb-2">{{ __('Цена') }}</label>

                            <input id="price" type="number" step="0.01" class="form-input rounded-md shadow-sm @error('price') border-red-500 @enderror" name="price" value="{{ old('price') }}" required>

                            @error('price')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700">{{ __('Сохранить') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
