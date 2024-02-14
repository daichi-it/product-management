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

    @if (session('isUpdate'))
    <p class="max-w-2xl text-sm text-gray-500">更新が完了しました。</p>
    @else
    <p class="max-w-2xl text-sm text-gray-500">登録が完了しました。</p>
    @endif
    <a class="btn btn-sm btn-dark" href="{{ route('items.index') }}">戻る</a>

</x-app-layout>



