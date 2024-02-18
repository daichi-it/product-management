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
            <dt class="pt-4">名前</dt>
            <dd><input type="text" name="name" value="{{ old('name', session('validatedData.name')) }}" class="border border-gray-300 rounded-md p-2"></dd>
            <dt class="pt-4">メールアドレス</dt>
            <dd><input type="text" name="email" value="{{ old('email', session('validatedData.email')) }}" class="border border-gray-300 rounded-md p-2"></dd>
            <dt class="pt-4">性別</dt>
            <dd>
                <label><input type="radio" name="gender" value="male" checked> 男性</label>
                <label><input type="radio" name="gender" value="female""> 女性</label>
            </dd>
            <div id="hobbyOrSkillSection">
                <dt id="hobbyOrSkillLabel" class="pt-4">趣味</dt>
                <dd><input type="text" id="hobbyOrSkillInput" name="shumi" class="border border-gray-300 rounded-md p-2"></dd>
            </div>
            <dt class="pt-4">電話番号</dt>
            <dd><input type="text" name="tel" value="{{ old('tel', session('validatedData.tel')) }}" class="border border-gray-300 rounded-md p-2"></dd>
            <dt class="pt-4">問い合わせ内容</dt>
            <dd><textarea name="message" class="border border-gray-300 rounded-md p-2">{{ old('price', session('validatedData.message')) }}</textarea></dd>
        </dl>
        
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            入力内容確認
        </button>
        <a href="{{ route('dashboard') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded ml-2">
            キャンセル
        </a>
    </form>
    <script>
    $(document).ready(function(){
        // 性別の選択が変更されたときのイベントハンドラー
        $('input[type="radio"][name="gender"]').change(function() {
            // 男性が選択された場合
            if ($(this).val() === 'male') {
                $('#hobbyOrSkillLabel').text('趣味');
                $('#hobbyOrSkillInput').attr('name', 'shumi');
            } 
            // 女性が選択された場合
            else if ($(this).val() === 'female') {
                $('#hobbyOrSkillLabel').text('特技');
                $('#hobbyOrSkillInput').attr('name', 'tokugi');
            }
        });
    });
    </script>
</x-app-layout>