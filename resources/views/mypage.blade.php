<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('MyPage') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mt-6 mx-auto max-w-7xl grid grid-cols-2 gap-4">
            <a href="{{ route('profile.edit') }}" class="block bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4 text-center text-blue-500 hover:underline">登録情報の変更</a>
            <a href="{{ route('items.create') }}" class="block bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4 text-center text-blue-500 hover:underline">お気に入り商品一覧</a>
            <a href="{{ route('contact.create') }}" class="block bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4 text-center text-blue-500 hover:underline">操作履歴</a>
        </div>
    </div>
</x-app-layout>
