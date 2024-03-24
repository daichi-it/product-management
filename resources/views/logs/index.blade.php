<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('ログ一覧画面') }}
        </h2>
    </x-slot>

    {{-- 一覧 --}}
    <div class="overflow-x-auto">
        <table class="table-auto w-full text-left text-sm">
            <thead>
                <tr class="bg-gray-200 text-gray-600">
                    <th class="text-left px-4 py-2 border border-gray-400 font-bold">日時</th>
                    <th class="text-left px-4 py-2 border border-gray-400 font-bold">ログ内容</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logs as $log)
                <tr class="@if($loop->odd) bg-gray-600 @endif">
                    <td class="text-white text-left px-4 py-2 border border-gray-400 font-bold">{{ Carbon\Carbon::parse($log->created_at)->format('Y年m月d日 H:i:s') }}</td>
                    <td class="text-white text-left px-4 py-2 border border-gray-400 font-bold">{{ $log->information }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4 flex justify-center">
        {{ $logs->appends(Request::all())->links() }}
    </div>

</x-app-layout>



