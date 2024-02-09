@extends("layouts.app")
@section("content")
<h1 class="text-2xl font-bold text-gray-800 mb-4">商品一覧</h1>
<div class="overflow-x-auto">
    <table class="table-auto w-full text-left text-sm">
    <thead>
        <tr class="bg-gray-200 text-gray-600">
        <th class="px-4 py-2">ID</th>
        <th class="px-4 py-2">商品名</th>
        <th class="px-4 py-2">入荷元</th>
        <th class="px-4 py-2">製造元</th>
        <th class="px-4 py-2">価格</th>
        <th class="px-4 py-2">登録日</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $item)
        <tr class="@if($loop->odd) bg-gray-50 @endif">
            <td class="px-4 py-2">{{ $item->id }}</td>
            <td class="px-4 py-2">{{ $item->product_name }}</td>
            <td class="px-4 py-2">{{ $item->arrival_source }}</td>
            <td class="px-4 py-2">{{ $item->manufacturer }}</td>
            <td class="px-4 py-2">{{ $item->price }}</td>
            <td class="px-4 py-2">{{ Carbon\Carbon::parse($item->created_at)->format('Y年m月d日') }}</td>
        </tr>
        @endforeach
    </tbody>
    </table>
</div>
<div class="mt-4 flex justify-center">
    {{ $items->appends(Request::all())->links() }}
</div>
@endsection