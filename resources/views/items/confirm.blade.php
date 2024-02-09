@extends("layouts.app")
@section("content")
@include('commons.errors')
<h1 class="text-3xl font-bold text-center mt-8">登録確認画面</h1>
@if(session('validatedData'))
<form action="{{ route('items.store') }}" method="post">
    @csrf
    <div class="bg-gray-100 p-4 rounded mt-4">
        <p class="text-lg">商品名: {{ session('validatedData')['product_name'] }}</p>
        <p class="text-lg">入荷元: {{ session('validatedData')['arrival_source'] }}</p>
        <p class="text-lg">製造元: {{ session('validatedData')['manufacturer'] }}</p>
        <p class="text-lg">価格: {{ session('validatedData')['price'] }}</p>
        <p class="text-lg">Email: {{ session('validatedData')['email'] }}</p>
        <p class="text-lg">電話番号: {{ session('validatedData')['tel'] }}</p>
    </div>
    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4">確認</button>
    <a href="{{ route('items.create') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mt-2">戻る</a>
</form>
@endif
@endsection