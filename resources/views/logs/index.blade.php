<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('ログ一覧画面') }}
        </h2>
    </x-slot>

    {{-- 一覧 --}}
    <div class="overflow-x-auto">
        <table class="table-auto w-full text-left text-sm ml-4">
            <thead>
                <tr class="bg-gray-200 text-gray-600">
                    <th class="px-4 py-2">日時</th>
                    <th class="px-4 py-2">ログ内容</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logs as $log)
                <tr class="@if($loop->odd) bg-gray-50 @endif">
                    <td class="px-4 py-2">{{ Carbon\Carbon::parse($log->created_at)->format('Y年m月d日 H:i:s') }}</td>
                    <td class="px-4 py-2">{{ $log->information }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4 flex justify-center">
        {{ $logs->appends(Request::all())->links() }}
    </div>

</x-app-layout>



