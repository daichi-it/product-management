@csrf 
<dl class="form-list">
    <dt>商品名</dt>
    <dd><input type="text" name="product_name" value="{{ old('product_name', session('validatedData.product_name')) }}" class="border border-gray-300 rounded-md p-2"></dd>
    <dt>入荷元</dt>
    <dd><input type="text" name="arrival_source" value="{{ old('arrival_source', session('validatedData.arrival_source')) }}" class="border border-gray-300 rounded-md p-2"></dd>
    <dt>製造元</dt>
    <dd><input type="text" name="manufacturer" value="{{ old('manufacturer', session('validatedData.manufacturer')) }}" class="border border-gray-300 rounded-md p-2"></dd>
    <dt>価格</dt>
    <dd><input type="text" name="price" value="{{ old('price', session('validatedData.price')) }}" class="border border-gray-300 rounded-md p-2"></dd>
</dl>






{{-- 

        <th class="px-4 py-2">ID</th>
        <th class="px-4 py-2">商品名</th>
        <th class="px-4 py-2">入荷元</th>
        <th class="px-4 py-2">製造元</th>
        <th class="px-4 py-2">価格</th>
        <th class="px-4 py-2">登録日</th>

            <td class="px-4 py-2">{{ $item->id }}</td>
            <td class="px-4 py-2">{{ $item->product_name }}</td>
            <td class="px-4 py-2">{{ $item->arrival_source }}</td>
            <td class="px-4 py-2">{{ $item->manufacturer }}</td>
            <td class="px-4 py-2">{{ $item->price }}</td>
            <td class="px-4 py-2">{{ Carbon\Carbon::parse($item->created_at)->format('Y年m月d日') }}</td> --}}

