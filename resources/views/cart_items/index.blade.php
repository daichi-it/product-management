<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('ショッピングカート') }}
        </h2>
    </x-slot>
    

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
        
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="py-3 px-6">商品名</th>
                            <th scope="col" class="py-3 px-6">価格</th>
                            <th scope="col" class="py-3 px-6">数量</th>
                            <th scope="col" class="py-3 px-6">小計</th>
                            <th scope="col" class="py-3 px-6">操作</th>
                        </tr>
                    </thead>
                    @php $totalAmount = 0; @endphp
                    <tbody>
                        @foreach ($cartItems as $item)
                        {{-- 各アイテムの小計を合計金額に加算 --}}
                        @php $totalAmount += $item->price * $item->pivot->quantity; @endphp
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="py-4 px-6">{{ $item->item_name }}</td>
                            <td class="py-4 px-6">{{ $item->price }}円</td>
                            <td class="py-4 px-6">
                                <select class="quantity" data-item-id="{{ $item->id }}">
                                    @for ($i = 0; $i <= 10; $i++)
                                        <option value="{{ $i }}" {{ $item->pivot->quantity == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </td>
                            <td class="py-4 px-6">{{ $item->price * $item->pivot->quantity }}円</td>
                            <td class="py-4 px-6">
                                <button class="delete-item bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" data-item-id="{{ $item->id }}">削除</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- 合計金額 --}}
                <div class="mt-6">
                    <p class="text-lg">合計金額: <span id="total-amount">{{ $totalAmount }}</span>円</p>
                </div>

                {{-- 戻るボタン、購入するボタン --}}
                <div class="mt-6 flex justify-between">
                    <a href="{{ route('dashboard') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">戻る</a>
                    <form action="{{ route('purchase') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">購入する</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    $(document).ready(function() {
        // 数量変更処理
        $('.quantity').change(function() {
            var itemId = $(this).data('item-id');
            var quantity = $(this).val();
    
            if(quantity == 0) {
                // 数量が0の場合、商品を削除
                $.ajax({
                    url: `/cart/delete/${itemId}`,
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(result) {
                        location.reload(); // ページを再読み込みして更新
                    },
                    error: function(xhr, status, error) {
                        alert('削除に失敗しました。'); // デバッグ用
                    }
                });
            } else {
                // 数量の更新
                $.ajax({
                    url: `/cart/update/${itemId}`,
                    type: 'POST',
                    data: {
                        _method: 'PATCH',
                        quantity: quantity,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(result) {
                        location.reload(); // ページを再読み込みして更新
                    },
                    error: function(xhr, status, error) {
                        alert(xhr.responseJSON.message); // デバッグ用
                    }
                });
            }
        });
    
        // 商品削除処理
        $('.delete-item').click(function() {
            var itemId = $(this).data('item-id');
    
            $.ajax({
                url: `/cart/delete/${itemId}`,
                type: 'POST',
                data: {
                    _method: 'DELETE',
                    _token: '{{ csrf_token() }}'
                },
                success: function(result) {
                    location.reload(); // ページを再読み込みして更新
                },
                error: function(xhr, status, error) {
                    alert(xhr.responseJSON.message); // デバッグ用
                }
            });
        });
    });
</script>


