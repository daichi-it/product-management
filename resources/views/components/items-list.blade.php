<div x-data="{ showModal: false, itemId: null }">
    {{-- 削除完了メッセージ --}}
    @if (session('status'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{{ session('status') }}</span>
    </div>
    @endif

    {{-- 検索 --}}
    <form method="GET" action="{{ request()->routeIs('items.favorite_items') ? route('items.favorite_items') : route('items.index') }}" class="mb-4">
        <div class="mt-4 flex flex-row gap-3 justify-center items-center w-full">
            <input type="text" name="keyword" placeholder="商品名・入荷元・製造元" value="{{ Request::get('keyword') }}"
                class="form-input text-gray-800 mt-1 block w-full sm:w-auto rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 flex-grow">
            <button type="submit" class="px-4 py-2 min-w-32 bg-blue-500 text-white rounded hover:bg-blue-700 transition duration-150 ease-in-out flex-shrink-0">
                検索
            </button>
        </div>
    </form>
    
    {{-- 一覧 --}}
    <div class="overflow-x-auto">
        <table class="table-auto w-full text-left text-sm border-collapse border border-gray-400">
            <thead>
                <tr class="bg-gray-200 text-gray-600">
                    <th class="text-left px-4 py-2 border border-gray-400 font-bold">ID</th>
                    <th class="px-4 py-2 border border-gray-400 font-bold">
                        {!! item_sort_link('item_name', '商品名') !!}
                    </th>
                    <th class="px-4 py-2 border border-gray-400 font-bold">
                        {!! item_sort_link('arrival_source', '入荷元') !!}
                    </th>
                    <th class="px-4 py-2 border border-gray-400 font-bold">
                        {!! item_sort_link('manufacturer', '製造元') !!}
                    </th>
                    <th class="px-4 py-2 border border-gray-400 font-bold">
                        {!! item_sort_link('price', '価格') !!}
                    </th>
                    <th class="px-4 py-2 border border-gray-400 font-bold">
                        {!! item_sort_link('created_at', '登録日') !!}
                    </th>
                    <th class="px-4 py-2 border border-gray-400 font-bold">お気に入り</th>
                    <th class="px-4 py-2 border border-gray-400 font-bold">カート</th>
                    <th class="px-4 py-2 border border-gray-400 font-bold">削除</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                <tr class="@if($loop->odd) bg-gray-600 @endif border border-gray-400">
                    <td class="px-4 py-2 border border-gray-400">
                        <a href="{{ route('items.edit', $item) }}" class="text-blue-300 underline hover:text-blue-100">
                            {{ $item->id }}
                        </a>
                    </td>
                    <td class="text-white px-4 py-2 border border-gray-400">{{ $item->item_name }}</td>
                    <td class="text-white px-4 py-2 border border-gray-400">{{ $item->arrival_source }}</td>
                    <td class="text-white px-4 py-2 border border-gray-400">{{ $item->manufacturer }}</td>
                    <td class="text-white px-4 py-2 border border-gray-400">{{ $item->price }}</td>
                    <td class="text-white px-4 py-2 border border-gray-400">{{ Carbon\Carbon::parse($item->created_at)->format('Y年m月d日') }}</td>
                    
                    <td class="px-4 py-2 border border-gray-400">
                        @if (!Auth::user()->is_favorite($item->id))
                        <form action="{{ route('favorite.store', $item) }}" method="post">
                            @csrf
                            <button class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-700">登録</button>
                        </form>
                        @else
                        <form action="{{ route('favorite.destroy', $item) }}" method="post">
                            @csrf
                            @method('delete')
                            <button class="bg-red-500 text-white font-bold py-2 px-4 rounded hover:bg-yellow-700">解除</button>
                        </form>
                        @endif
                    </td>

                    <td class="px-4 py-2 border border-gray-400">
                        <form action="{{ route('cart_items.add_cart', $item) }}" method="post">
                            @csrf
                            <button class="add-to-cart-button bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-700">カートに入れる</button>
                        </form>
                    </td>

                    <td class="px-4 py-2 border border-gray-400">
                        <button type="button" x-on:click="showModal = true; itemId = {{ $item->id }}" class="bg-red-500 text-white font-bold py-2 px-4 rounded hover:bg-red-700">
                            削除
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4 flex justify-center">
        {{ $items->appends(Request::all())->links() }}
    </div>
    
    {{-- モーダル --}}
    <div x-show="showModal" style="display: none;" class="fixed inset-0 z-60 flex justify-center items-center overflow-y-auto h-full w-full bg-gray-600 bg-opacity-50" @click="showModal = false">        
        <div class="px-4 py-4 relative border w-1/2 max-w-4xl shadow-lg rounded-md bg-white" style="transform: none;" @click.stop>
            <div class="modal-header">
                <h3 class="text-lg leading-6 font-medium text-gray-900">商品削除確認</h3>
            </div>
            <div class="modal-body mt-2 px-7 py-3">
                <p class="text-sm text-gray-500" x-text="'ID:' + itemId + ' の商品を削除してよろしいですか？'"></p>
            </div>
            <div class="modal-footer items-center px-4 py-3">
                <button x-on:click="showModal = false" class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    キャンセル
                </button>
                <form method="POST" :action="'/items/' + itemId" x-data>
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="mt-3 w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-bold text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        削除する
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(function() {
    $('.add-to-cart-button').on('click', function(e) {
        e.preventDefault();

        var formAction = $(this).closest('form').attr('action');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: formAction,
            type: 'POST',
            data: {}
        })
        .done(function(response) {
            alert('商品をカートに追加しました。');
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            alert('商品をカートに追加できませんでした。');
        });
    });
});
</script>