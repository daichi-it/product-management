@extends("layouts.app")

@section("content")
@if (session('isUpdate'))
<p class="max-w-2xl text-sm text-gray-500">更新が完了しました。</p>
@else
<p class="max-w-2xl text-sm text-gray-500">登録が完了しました。</p>
@endif
<a class="btn btn-sm btn-dark" href="{{ route('items.index') }}">戻る</a>
@endsection