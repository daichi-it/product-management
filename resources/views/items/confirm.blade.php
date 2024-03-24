<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            @if (session('isUpdate'))
                {{ __('更新確認画面') }}
            @else
                {{ __('登録確認画面') }}
            @endif
        </h2>
    </x-slot>

    @include('commons.errors')
    @if(session('data'))
    <form action="{{ session('isUpdate') ? route('items.update', $item) : route('items.store') }}" method="post">
        @csrf
        @if (session('isUpdate'))
            @method('PATCH')
        @endif
        <div class="bg-gray-800 p-4 rounded mt-4">
            <p class="text-white text-lg">商品名: {{ session('data')['item_name'] }}</p>
            <p class="text-white text-lg">入荷元: {{ session('data')['arrival_source'] }}</p>
            <p class="text-white text-lg">製造元: {{ session('data')['manufacturer'] }}</p>
            <p class="text-white text-lg">価格: {{ session('data')['price'] }}</p>
            <p class="text-white text-lg">Email: {{ session('data')['email'] }}</p>
            <p class="text-white text-lg">電話番号: {{ session('data')['tel'] }}</p>
        </div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4">確認</button>
        <a href="{{ session('isUpdate') ? route('items.update', $item) : route('items.create') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mt-2">戻る</a>
    </form>
    @endif
</x-app-layout>


