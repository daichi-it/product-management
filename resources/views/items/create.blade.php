@extends("layouts.app")
@section("content")
@include('commons.errors')
<h1 class="text-3xl font-bold text-center mt-8">商品新規登録</h1>
<form action="{{ route('items.confirm') }}" method="post">
    @include('items.form')
    <dt>メールアドレス</dt>
    <dd><input type="text" name="email" value="{{ old('email', session('validatedData.email')) }}" class="border border-gray-300 rounded-md p-2"></dd>
    <dt>電話番号</dt>
    <dd><input type="text" name="tel" value="{{ old('tel', session('validatedData.tel')) }}" class="border border-gray-300 rounded-md p-2"></dd>
    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">登録</button>
    <a href="{{ route('items.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">キャンセル</a>
</form>
@endsection