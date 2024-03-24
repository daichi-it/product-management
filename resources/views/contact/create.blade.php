<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('お問い合わせ入力画面') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        @include('commons.errors')
        <form method="POST" action="{{ route('contact.confirm') }}">
            @csrf
            <dl class="form-list">
                <dt class="text-white">名前</dt>
                <dd class="pb-3"><input type="text" name="name" value="{{ old('name', session('validatedData.name')) }}" class="text-gray-800 rounded-md p-2"></dd>
                <dt class="text-white">メールアドレス</dt>
                <dd class="pb-3"><input type="text" name="email" value="{{ old('email', session('validatedData.email')) }}" class="text-gray-800 rounded-md p-2"></dd>
                <dt class="text-white">性別</dt>
                <dd class="pb-3">
                    <label class="text-white"><input type="radio" name="gender" value="male" {{ old('gender', session('validatedData.gender')) == 'female' ? '' : 'checked' }}> 男性</label>
                    <label class="text-white"><input type="radio" name="gender" value="female" {{ old('gender', session('validatedData.gender')) == 'female' ? 'checked' : '' }}> 女性</label>
                </dd>
                <div class="pb-3" id="hobbyOrSkillSection">
                    <dt id="hobbyOrSkillLabel" class="text-white">　</dt>
                    <dd><input type="text" name="hobby" value="{{ old('hobby', session('validatedData.hobby')) }}" class="text-gray-800 rounded-md p-2"></dd>
                    <dd><input type="text" name="skill" value="{{ old('skill', session('validatedData.skill')) }}" class="hidden text-gray-800 rounded-md p-2"></dd>
                </div>
                <dt class="text-white">電話番号</dt>
                <dd class="pb-3"><input type="text" name="tel" value="{{ old('tel', session('validatedData.tel')) }}" class="text-gray-800 rounded-md p-2"></dd>
                <dt class="text-white">問い合わせ内容</dt>
                <dd class="pb-3"><textarea name="message" class="text-gray-800 rounded-md p-2">{{ old('message', session('validatedData.message')) }}</textarea></dd>
            </dl>
            
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                入力内容確認
            </button>
            <a href="{{ route('dashboard') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded ml-2">
                キャンセル
            </a>
        </form>
    </div>
    
    <script>
    $(document).ready(function(){
        // 性別の選択が変更されたときのイベントハンドラー
        $('input[type="radio"][name="gender"]').change(function() {
            // 男性が選択された場合
            if ($(this).is(':checked') && $(this).val() === 'male') {
                $('#hobbyOrSkillLabel').text('趣味');
                $('input[name="hobby"]').removeClass('hidden');
                $('input[name="skill"]').addClass('hidden').val('');
            } 
            // 女性が選択された場合
            else if ($(this).is(':checked') && $(this).val() === 'female') {
                $('#hobbyOrSkillLabel').text('特技');
                $('input[name="skill"]').removeClass('hidden');
                $('input[name="hobby"]').addClass('hidden').val('');
            }
        }).change(); // 初期表示
    });
    </script>
</x-app-layout>