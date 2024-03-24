<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            @if (session('isUpdate'))
                {{ __('更新完了画面') }}
            @else
                {{ __('登録完了画面') }}
            @endif
        </h2>
    </x-slot>


    <div id="completeForm"  class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-center">
        @if (session('isUpdate'))
        <p class="text-white text-lg py-6 px-4">更新が完了しました。</p>
        @else
        <p class="text-white text-lg py-6 px-4">登録が完了しました。</p>
        @endif
        <a class="bg-green-500 text-white font-bold py-2 px-4 rounded hover:bg-green-700" href="{{ route('items.index') }}">戻る</a>
    </div>




</x-app-layout>



