@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        @if (session('success'))
            <div class="bg-green-100 text-green-900 py-4 px-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold">Товары</h2>
            <a href="{{ route('goods.create') }}" class="py-2 px-4 bg-blue-500 hover:bg-blue-600 text-white rounded transition duration-200">Добавить</a>
        </div>

        <div class="bg-white rounded shadow overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Название</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Цена</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Действия</th>
                </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                @foreach ($goods as $goodsItem)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $goodsItem->product_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $goodsItem->product_price }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('goods.edit', $goodsItem->id) }}" class="py-1 px-3 bg-blue-500 hover:bg-blue-600 text-white rounded transition duration-200"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('goods.destroy', $goodsItem->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="py-1 px-3 bg-red-500 hover:bg-red-600 text-white rounded transition duration-200" onclick="return confirm('Вы уверены что хотите удалить товар {{$goodsItem->product_name}}?')"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{$goods->links()}}
        </div>
    </div>
@endsection
