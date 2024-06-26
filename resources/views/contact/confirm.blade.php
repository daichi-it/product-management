<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('お問い合わせ確認画面') }}
        </h2>
    </x-slot>

    @include('commons.errors')
    @if(session('validatedData'))
    <form action="{{ route('contact.send') }}" method="post" class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        @csrf
        <div class="bg-gray-800 p-4 rounded mt-4">
            <p class="text-white text-lg">名前: {{ session('validatedData')['name'] }}</p>
            <p class="text-white text-lg">メールアドレス: {{ session('validatedData')['email'] }}</p>
            <p class="text-white text-lg">性別: {{ session('validatedData')['gender'] === 'male' ? '男性' : '女性' }}</p>
            @if(session('validatedData')['gender'] === 'male' && isset(session('validatedData')['hobby']))
                <p class="text-white text-lg">趣味: {{ session('validatedData')['hobby'] }}</p>
            @elseif(session('validatedData')['gender'] === 'female' && isset(session('validatedData')['skill']))
                <p class="text-white text-lg">特技: {{ session('validatedData')['skill'] }}</p>
            @endif
            <p class="text-white text-lg">電話番号: {{ session('validatedData')['tel'] }}</p>
            <p class="text-white text-lg">問い合わせ内容: {{ session('validatedData')['message'] }}</p>
        </div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4">送信</button>
        <a href="{{ route('contact.create') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mt-2">戻る</a>
    </form>
    @endif
</x-app-layout>


