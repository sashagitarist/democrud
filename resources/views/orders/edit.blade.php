@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-6">Редактировать заказ № {{$order->id}}</h1>
        <form method="POST" action="{{ route('orders.update', $order) }}" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" novalidate>
            @csrf
            @method('PUT')

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

            <div class="mb-4">
                <label for="order_date" class="block text-gray-700 font-bold mb-2">Дата заказа</label>
                <input id="order_date" type="text" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('order_date') border-red-500 @enderror" name="order_date" value="{{ old('order_date', $date) }}" required autocomplete="off">
                @error('order_date')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="phone" class="block text-gray-700 font-bold mb-2">Телефон</label>
                <input id="phone" type="tel" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('phone') border-red-500 @enderror" name="phone" value="{{ old('phone', $order->phone) }}" autocomplete="tel">
                @error('phone')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-bold mb-2">Email</label>
                <input id="email" type="email" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror" name="email" value="{{ old('email', $order->email) }}" required autocomplete="email">
                @error('email')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="address" class="block text-gray-700 font-bold mb-2">Адрес</label>
                <div id="map" style="width: 100%; height: 400px"></div>
                <input id="address" type="text" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('address') border-red-500 @enderror" name="address" value="{{ old('address', $order->address) }}" readonly>
                <input type="hidden" class="form-control" id="coordinates" name="location" value="{{ old('location', $order->location) }}">
                @error('address')
                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <div id="products">
                    @foreach($goods as $good)
                        <div>
                            <div class="mb-4 product-row">
                                <label class="block text-gray-700 font-bold mb-2">Товары</label>
                                <select class="product-select appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="products[]" required>
                                    <option value="{{$good->pivot->goods_id}}" selected>{{$good->product_name}}</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                    @endforeach
                                </select>
                                <input type="number" name="quantities[]" value="{{ $good->pivot->quantity }}" required min="1" class="product-quantity appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Количество">
                                <button type="button" class="remove-product bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded ml-2">Удалить</button>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
            <div class="mb-4">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2" type="button" id="add-product">Добавить товар</button>
            </div>

            <div id="product-template" style="display:none">
                <div class="mb-4 product-row">
                    <label class="block text-gray-700 font-bold mb-2">Товар</label>
                    <select class="product-select appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="products[]" required>
                        <option value="" disabled selected>-- Выбрать товар --</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                        @endforeach
                    </select>
                    <input type="number" name="quantities[]" value="" required min="1" class="product-quantity appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Количество">
                    <button type="button" class="remove-product bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded ml-2">Удалить</button>
                </div>
            </div>

            <div id="total">{{$order->amount}}</div>

            <button id="submit" type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Обновить заказ
            </button>
        </form>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        const phoneInput = document.getElementById('phone');
        Inputmask({mask: "+7 (999) 999-99-99"}).mask(phoneInput);
    </script>

    <script type="module">
        $(function() {
            $('#order_date').datepicker({
                dateFormat: 'dd.mm.yy',
                minDate: 0,
            });
        });
    </script>

    <script type="module">
        $(document).ready(function() {
            $('#add-product').click(function () {
                var template = $('#product-template').html();
                $('#products').append(template);
            });
            $('#submit').click(function () {
                $('#product-template').remove();
            });
            $(document).on('click', '.remove-product', function () {
                $(this).closest('.product-row').remove();
            });
        });
    </script>

    <script type="text/javascript">
        function init () {
            start = document.getElementById("coordinates").value;
            zoom = 18;
            id = 'map';
            start = start.split(',');
            lat = start[0];
            long = start[1];
            coords = [lat, long];

            Map = new ymaps.Map(id, {
                center: coords,
                zoom: zoom,
                controls: ['zoomControl']
            });

            var search = new ymaps.control.SearchControl({
                options: {
                    float: 'left',
                    floatIndex: 100,
                    noPlacemark: true
                }
            });

            Map.controls.add(search);

            mark = new ymaps.Placemark([lat, long],{}, {preset: "islands#redIcon", draggable: true});
            Map.geoObjects.add(mark);

            mark.events.add("dragend", function () {
                coords = this.geometry.getCoordinates();
                save();
            }, mark);

            Map.events.add('click', function (e) {
                coords = e.get('coords');
                save();
            });

            search.events.add("resultselect", function () {
                var fn = document.getElementById('address');
                fn.value = '';
                adrr = search.getResultsArray()[0];
                coords = search.getResultsArray()[0].geometry.getCoordinates();
                save();
                document.getElementById('address').value += search.getRequestString();
            });

        }

        function save (){
            var new_coords = [coords[0].toFixed(6), coords[1].toFixed(6)];
            mark.getOverlaySync().getData().geometry.setCoordinates(new_coords);
            document.getElementById("coordinates").value = new_coords;
        }

        ymaps.ready(init);
    </script>
@endsection
