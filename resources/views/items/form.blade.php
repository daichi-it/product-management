@csrf 
<dl class="form-list">
    <dt>商品名</dt>
    <dd><input type="text" name="product_name" value="{{ old('product_name', session('data.product_name', $item->product_name ?? '')) }}" class="border border-gray-300 rounded-md p-2"></dd>
    <dt>入荷元</dt>
    <dd><input type="text" name="arrival_source" value="{{ old('arrival_source', session('data.arrival_source', $item->arrival_source ?? '')) }}" class="border border-gray-300 rounded-md p-2"></dd>
    <dt>製造元</dt>
    <dd><input type="text" name="manufacturer" value="{{ old('manufacturer', session('data.manufacturer', $item->manufacturer ?? '')) }}" class="border border-gray-300 rounded-md p-2"></dd>
    <dt>価格</dt>
    <dd><input type="text" name="price" value="{{ old('price', session('data.price', $item->price ?? '')) }}" class="border border-gray-300 rounded-md p-2"></dd>
    <dt>メールアドレス</dt>
    <dd><input type="text" name="email" value="{{ old('email', session('data.email')) }}" class="border border-gray-300 rounded-md p-2"></dd>
    <dt>電話番号</dt>
    <dd><input type="text" name="tel" value="{{ old('tel', session('data.tel')) }}" class="border border-gray-300 rounded-md p-2"></dd>
</dl>


