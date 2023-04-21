@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Успешно!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if(count($errors)>0)
            @foreach ($errors->all() as $error)
                    <div role="alert">
                        <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                            Ошибка!
                        </div>
                        <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                            <p>{{$error}}</p>
                        </div>
                    </div>
            @endforeach
        @endif
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold">Заказы</h2>
            <a href="{{ route('orders.create') }}" class="py-2 px-4 bg-blue-500 hover:bg-blue-600 text-white rounded transition duration-200">Создать</a>
        </div>

        <table class="table w-full" id="orders-table">
            <thead>
            <tr class="bg-gray-100 text-left">
                <th class="py-2 px-4">№</th>
                <th class="py-2 px-4">Дата заказа</th>
                <th class="py-2 px-4">Email</th>
                <th class="py-2 px-4">Адрес</th>
                <th class="py-2 px-4">Сумма</th>
                <th class="py-2 px-4">Изменить</th>
                <th class="py-2 px-4">Удалить</th>
            </tr>
            </thead>
        </table>
    </div>
@endsection

@section('scripts')
    <script>
        $(function() {
            $('#orders-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('orders.index') }}',
                columns: [
                    { data: 'id', name: 'id', className: 'py-2 px-4' },
                    { data: 'order_date', name: 'order_date', className: 'py-2 px-4' },
                    { data: 'email', name: 'email', className: 'py-2 px-4' },
                    { data: 'address', name: 'address', className: 'py-2 px-4' },
                    { data: 'order_amount', name: 'order_amount', className: 'py-2 px-4' },
                    {
                        data: null,
                        className: 'py-2 px-4',
                        render: function (data, type, row) {
                            return '<a href="/orders/' + data.id + '/edit" class="py-2 px-4 bg-blue-500 hover:bg-blue-600 text-white rounded transition duration-200"><i class="fas fa-edit"></i></a>';
                        }
                    },
                    {
                        data: null,
                        className: 'py-2 px-4',
                        render: function (data, type, row) {
                            return '<form method="POST" action="/orders/'
                                + data.id + '" onsubmit="return confirm(\'Вы уверены?\')">' +
                                '<input type="hidden" name="_token" value="'
                                + $('meta[name="csrf-token"]').attr('content') + '">' +
                                '<input type="hidden" name="_method" value="DELETE">' +
                                '<button type="submit" class="py-2 px-4 bg-red-500 hover:bg-red-600 text-white rounded transition duration-200"><i class="fas fa-trash-alt"></i></button>' +
                                '</form>';
                        }
                    }
                ]
            });
            document.getElementById('orders-table_wrapper').style.overflowX = 'scroll';
        });
    </script>
@endsection
