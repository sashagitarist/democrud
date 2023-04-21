@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-3 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-md mt-3 px-3 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="mb-4 text-sm text-gray-600">
                {{ __('Это ваш API токен. Никому не сообщайте!') }}
            </div>
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $token }}
            </div>
            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('dashboard') }}">
                    {{ __('Вернуться в панель управления') }}
                </a>
            </div>
        </div>
    </div>
@endsection
