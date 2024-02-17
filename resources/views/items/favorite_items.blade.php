<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('お気に入り商品一覧画面') }}
        </h2>
    </x-slot>
    
    <x-items-list :items="$items" />
</x-app-layout>
