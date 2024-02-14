<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('お問い合わせ確認画面') }}
        </h2>
    </x-slot>

    @include('commons.errors')
    @if(session('validatedData'))
    <form action="{{ route('contact.send') }}" method="post">
        @csrf
        <div class="bg-gray-100 p-4 rounded mt-4">
            <p class="text-lg">名前: {{ session('validatedData')['name'] }}</p>
            <p class="text-lg">メールアドレス: {{ session('validatedData')['email'] }}</p>
            <p class="text-lg">電話番号: {{ session('validatedData')['tel'] }}</p>
            <p class="text-lg">問い合わせ内容: {{ session('validatedData')['message'] }}</p>
        </div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4">送信</button>
        <a href="{{ route('items.create') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mt-2">戻る</a>
    </form>
    @endif
</x-app-layout>


