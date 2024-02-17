@csrf 
<dl class="form-list">
    <dt>商品名</dt>
    <dd><input type="text" name="item_name" value="{{ old('item_name', $data['item_name']) }}" class="border border-gray-300 rounded-md p-2"></dd>
    <dt>入荷元</dt>
    <dd><input type="text" name="arrival_source" value="{{ old('arrival_source', $data['arrival_source']) }}" class="border border-gray-300 rounded-md p-2"></dd>
    <dt>製造元</dt>
    <dd><input type="text" name="manufacturer" value="{{ old('manufacturer', $data['manufacturer']) }}" class="border border-gray-300 rounded-md p-2"></dd>
    <dt>価格</dt>
    <dd><input type="text" name="price" value="{{ old('price', $data['price']) }}" class="border border-gray-300 rounded-md p-2"></dd>
    <dt>メールアドレス</dt>
    <dd><input type="text" name="email" value="{{ old('email', $data['email']) }}" class="border border-gray-300 rounded-md p-2"></dd>
    <dt>電話番号</dt>
    <dd><input type="text" name="tel" value="{{ old('tel', $data['tel']) }}" class="border border-gray-300 rounded-md p-2"></dd>
</dl>


