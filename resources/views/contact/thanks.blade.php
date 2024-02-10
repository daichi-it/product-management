@extends("layouts.app")
@section("content")
<div class="flex items-center justify-center min-h-screen">
    <div class="border border-gray-300 p-4 text-center shadow-lg rounded-lg">
        <h2 class="text-xl font-semibold text-gray-800">お問い合わせ</h2>
        <p class="text-gray-600">問い合わせを受け付けました。</p>
        <p class="mb-6 text-gray-600">ご返信をお待ちください。</p>
        <a href="{{ route('dashboard') }}"
           class="inline-block px-6 py-2 text-sm font-semibold text-blue-800 bg-blue-100 rounded hover:bg-blue-200">
            戻る
        </a>
    </div>
</div>
@endsection

