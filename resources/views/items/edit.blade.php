<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('商品編集画面') }}
        </h2>
    </x-slot>

    @include('commons.errors')
    <form action="{{ route('items.update.confirm', $item) }}" method="post">
        @include('items.form')
        <button type="submit">更新する</button>
        <div class="nav-item" style="display: inline-flex; align-items: center; margin-right: 5px;">
            <a class="btn btn-sm btn-dark" href="{{ route('items.index') }}">キャンセル</a>
        </div>
    </form>
</x-app-layout>




