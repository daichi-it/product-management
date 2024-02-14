<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('商品新規登録画面') }}
        </h2>
    </x-slot>

    @include('commons.errors')
    <form action="{{ route('items.confirm') }}" method="post">
        @include('items.form')
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">登録</button>
        <a href="{{ route('items.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">キャンセル</a>
    </form>
</x-app-layout>


