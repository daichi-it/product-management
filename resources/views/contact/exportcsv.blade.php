<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            問い合わせCSVエクスポート
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
                <div class="form-group">
                    <label for="yearMonth">出力年月:</label>
                    <select id="yearMonth" class="form-control">
                        @foreach($dates as $date)
                            <option value="{{ $date }}">{{ $date }}</option>
                        @endforeach
                    </select>
                </div>
                <button id="exportCsv" class="btn btn-primary">CSVエクスポート</button>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        $('#exportCsv').click(function() {
            var yearMonth = $('#yearMonth').val();
            $.ajax({
                url: '/contact/exportCsv/${yearMonth}',
                type: 'GET',
                data: { formatted_date: yearMonth },
                xhrFields: { responseType: 'blob' },
                success: function(response, status, xhr) {
                    alert(disposition);
                    var disposition = xhr.getResponseHeader('Content-Disposition');
                    var filename = 'export.csv'; // デフォルトのファイル名
                    if (disposition && disposition.indexOf('filename=') !== -1) {
                        filename = disposition.split('filename=')[1].trim(); // ファイル名を取得
                        // filename = filename.replace(/['"]/g, ''); // クォートを除去
                    }
                    var blob = new Blob([response], { type: 'application/octet-stream' });
                    var downloadUrl = window.URL.createObjectURL(blob);
                    var a = document.createElement("a");
                    a.href = downloadUrl;
                    a.download = filename;
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(downloadUrl);
                    a.remove();
                },
                error: function(xhr, status, error) {
                    console.error("CSVエクスポートエラー:", error);
                }
            });
        });
    });

    </script>
</x-app-layout>
