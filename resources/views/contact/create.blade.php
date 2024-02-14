<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('お問い合わせ入力画面') }}
        </h2>
    </x-slot>

    @include('commons.errors')
    <form method="POST" action="{{ route('contact.confirm') }}">
        @csrf
        <dl class="form-list">
            <dt>名前</dt>
            <dd><input type="text" name="name" value="{{ old('name', session('validatedData.name')) }}" class="border border-gray-300 rounded-md p-2"></dd>
            <dt>メールアドレス</dt>
            <dd><input type="text" name="email" value="{{ old('email', session('validatedData.email')) }}" class="border border-gray-300 rounded-md p-2"></dd>
            <dt>電話番号</dt>
            <dd><input type="text" name="tel" value="{{ old('tel', session('validatedData.tel')) }}" class="border border-gray-300 rounded-md p-2"></dd>
            <dt>問い合わせ内容</dt>
            <dd><textarea name="message" class="border border-gray-300 rounded-md p-2">{{ old('price', session('validatedData.message')) }}</textarea></dd>
        </dl>
        
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            入力内容確認
        </button>
        <a href="{{ route('dashboard') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded ml-2">
            キャンセル
        </a>
    </form>
</x-app-layout>