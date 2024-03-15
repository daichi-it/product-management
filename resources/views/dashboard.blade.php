<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
        <div class="mt-6 mx-auto max-w-7xl grid grid-cols-2 gap-4">
            <a href="{{ route('items.index') }}" class="block bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4 text-center text-blue-500 hover:underline">商品一覧</a>
            <a href="{{ route('items.create') }}" class="block bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4 text-center text-blue-500 hover:underline">商品新規追加</a>
            <a href="{{ route('contact.create') }}" class="block bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4 text-center text-blue-500 hover:underline">問い合わせ</a>
            <a href="{{ route('shippings.index') }}" class="block bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4 text-center text-blue-500 hover:underline">出荷先一覧</a>
            <a href="{{ route('shippings.register') }}" class="block bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4 text-center text-blue-500 hover:underline">出荷先登録</a>
            <a href="{{ route('mypage') }}" class="block bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4 text-center text-blue-500 hover:underline">マイページ</a>
        </div>
    </div>
</x-app-layout>