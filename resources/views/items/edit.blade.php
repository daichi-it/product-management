<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('商品編集画面') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        @include('commons.errors')
        <form action="{{ route('items.update.confirm', $item) }}" method="post">
            @include('items.form')
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">更新する</button>
            <div class="nav-item" style="display: inline-flex; align-items: center; margin-right: 5px;">
                <a href="{{ route('items.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">キャンセル</a>
            </div>
        </form>
    </div>
</x-app-layout>




