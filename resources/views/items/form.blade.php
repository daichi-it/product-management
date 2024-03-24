@csrf 
<dl class="form-list">
    <dt class="text-white">商品名</dt>
    <dd class="pb-3"><input type="text" name="item_name" value="{{ old('item_name', $data['item_name']) }}" class="text-gray-800 rounded-md p-2"></dd>
    <dt class="text-white">入荷元</dt>
    <dd class="pb-3"><input type="text" name="arrival_source" value="{{ old('arrival_source', $data['arrival_source']) }}" class="text-gray-800 rounded-md p-2"></dd>
    <dt class="text-white">製造元</dt>
    <dd class="pb-3"><input type="text" name="manufacturer" value="{{ old('manufacturer', $data['manufacturer']) }}" class="text-gray-800 rounded-md p-2"></dd>
    <dt class="text-white">価格</dt>
    <dd class="pb-3"><input type="text" name="price" value="{{ old('price', $data['price']) }}" class="text-gray-800 rounded-md p-2"></dd>
    <dt class="text-white">メールアドレス</dt>
    <dd class="pb-3"><input type="text" name="email" value="{{ old('email', $data['email']) }}" class="text-gray-800 rounded-md p-2"></dd>
    <dt class="text-white">電話番号</dt>
    <dd class="pb-3"><input type="text" name="tel" value="{{ old('tel', $data['tel']) }}" class="text-gray-800 rounded-md p-2"></dd>
</dl>


