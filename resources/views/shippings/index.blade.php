<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('出荷先一覧画面') }}
        </h2>
    </x-slot>
    
    <div x-data="{ showModal: false, shippingId: null }">
        {{-- 削除完了メッセージ --}}
        @if (session('status'))
        <div class="text-green-100 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('status') }}</span>
        </div>
        @endif
    
        {{-- 一覧 --}}
        <div class="overflow-x-auto">
            <table class="table-auto w-full text-left text-sm">
                <thead>
                    <tr class="bg-gray-200 text-gray-600">
                        <th class="text-left px-4 py-2 border border-gray-400 font-bold">ID</th>
                        <th class="px-4 py-2 border border-gray-400 font-bold">出荷先名</th>
                        <th class="px-4 py-2 border border-gray-400 font-bold">出荷先住所</th>
                        <th class="px-4 py-2 border border-gray-400 font-bold">出荷先電話番号</th>
                        <th class="px-4 py-2 border border-gray-400 font-bold">登録日</th>
                        <th class="px-4 py-2 border border-gray-400 font-bold">削除</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($shippings as $shipping)
                    <tr class="@if($loop->odd) bg-gray-600 @endif">
                        <td class="text-white px-4 py-2 border border-gray-400">{{ $shipping->id }}
                            {{-- <a href="{{ route('shippings.edit', $shipping) }}" class="bg-green-500 text-white font-bold py-2 px-4 rounded hover:bg-green-700">編集</a> --}}
                        </td>
                        <td class="text-white px-4 py-2 border border-gray-400">{{ $shipping->name }}</td>
                        <td class="text-white px-4 py-2 border border-gray-400">{{ $shipping->address }}</td>
                        <td class="text-white px-4 py-2 border border-gray-400">{{ $shipping->tel }}</td>
                        <td class="text-white px-4 py-2 border border-gray-400">{{ Carbon\Carbon::parse($shipping->created_at)->format('Y年m月d日') }}</td>
                        <td class="text-white px-4 py-2 border border-gray-400">
                            <button type="button" x-on:click="showModal = true; shippingId = {{ $shipping->id }}" class="bg-red-500 text-white font-bold py-2 px-4 rounded hover:bg-red-700">
                                削除
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    
        <div class="mt-4 flex justify-center">
            {{ $shippings->appends(Request::all())->links() }}
        </div>
        
        {{-- モーダル --}}
        <div x-show="showModal" style="display: none;" class="fixed inset-0 flex justify-center items-center overflow-y-auto h-full w-full bg-gray-600 bg-opacity-50" x-on:click.away="showModal = false">        
            <div class="relative p-10 border w-1/2 max-w-4xl shadow-lg rounded-md bg-white" style="transform: none;">
                <div class="modal-header">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">出荷先削除確認</h3>
                </div>
                <div class="modal-body mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500" x-text="'ID:' + shippingId + ' の出荷先を削除してよろしいですか？'"></p>
                </div>
                <div class="modal-footer items-center px-4 py-3">
                    <button x-on:click="showModal = false" class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        キャンセル
                    </button>
                    <form method="POST" :action="'/shippings/' + shippingId" x-data>
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
</x-app-layout>



