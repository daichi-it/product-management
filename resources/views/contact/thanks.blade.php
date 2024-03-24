<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('お問い合わせ完了画面') }}
        </h2>
    </x-slot>

    <div class="flex items-center justify-center min-h-screen">
        <div class="border border-gray-300 bg-gray-800 p-4 text-center shadow-lg rounded-lg">
            <p class="text-gray-100">お問い合わせを受け付けました。</p>
            <p class="mb-6 text-gray-100">ご返信をお待ちください。</p>
            <a href="{{ route('dashboard') }}"
               class="inline-block px-6 py-2 text-sm font-semibold text-blue-800 bg-blue-100 rounded hover:bg-blue-200">
                戻る
            </a>
        </div>
    </div>
</x-app-layout>