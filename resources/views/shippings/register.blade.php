<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('出荷先登録') }}
        </h2>
    </x-slot>
    
    <div id="app" class="px-4"></div>

    <script>
        // 入力値の一時保存用オブジェクト
        let tempFormData = {}; 

        // 各画面のHTMLを定数で定義
        const inputFormHTML = `
            <div id="inputForm" class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div id="errorMessages" style="color:red;"></div>
                <form id="shippingForm">
                    <dl class="form-list">
                        <dt>出荷先名</dt>
                        <dd><input type="text" id="name" name="name" class="border border-gray-300 rounded-md p-2"></dd>
                        <dt>出荷先住所</dt>
                        <dd><input type="text" id="address" name="address" class="border border-gray-300 rounded-md p-2"></dd>
                        <dt>電話番号</dt>
                        <dd><input type="text" id="tel" name="tel" class="border border-gray-300 rounded-md p-2"></dd>
                    </dl>
                    <button class="bg-red-500 text-white font-bold py-2 px-4 rounded hover:bg-green-700" type="button" id="toConfirm">確認画面へ</button>
                </form>
            </div>
        `;

        const confirmFormHTML = (name, address, tel) => `
            <div id="confirmForm" class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div id="confirmDetails">
                    <dl class="form-list">
                        <dt>会社名</dt>
                        <dd>${name}</dd>
                        <dt>住所</dt>
                        <dd>${address}</dd>
                        <dt>電話番号</dt>
                        <dd>${tel}</dd>
                    </dl>
                </div>
                <button class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-700" type="button" id="submitForm">送信</button>
                <button class="bg-gray-500 text-white font-bold py-2 px-4 rounded hover:bg-gray-700" type="button" id="backToInput">戻る</button>
            </div>
        `;

        const completeFormHTML = `
            <div id="completeForm"  class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-center">
                <p class="mb-4">登録が完了しました。</p>
                <button class="bg-green-500 text-white font-bold py-2 px-4 rounded hover:bg-green-700" type="button" id="newRegister">戻る</button>
            </div>
        `;

        // CSRFトークン設定
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // 画面名を更新する関数
        function updateHeader(title) {
            document.querySelector("header h2").textContent = title;
        }
        
        function navigateTo(page) {            
            if (page === 'inputForm') {
                $('main').html(inputFormHTML);
                updateHeader('出荷先登録入力');
                // tempFormDataの値をフォームに設定
                setTimeout(() => {
                    if (Object.keys(tempFormData).length > 0) {
                        $('#name').val(tempFormData.name);
                        $('#address').val(tempFormData.address);
                        $('#tel').val(tempFormData.tel);
                    }
                }, 0);
                attachEvents();
            } else if (page === 'confirmForm') {
                // サーバー側での入力チェックを行う
                $.ajax({
                    url: '/shippings/confirm',
                    type: 'POST',
                    data: tempFormData,
                    success: function(response) {
                        // チェックOKの場合、確認画面へ遷移
                        $('main').html(confirmFormHTML(tempFormData.name, tempFormData.address, tempFormData.tel));
                        updateHeader('出荷先登録確認');
                        attachEvents();
                    },
                    error: function(xhr, status, error) {
                        if (xhr.status === 422) {
                            // バリデーションエラー
                            var errorMessages = xhr.responseJSON.errors;
                            var errorMessageHtml = '<ul class="alert">';
                            for (var key in errorMessages) {
                                if (errorMessages.hasOwnProperty(key)) {
                                    errorMessageHtml += '<li>' + errorMessages[key].join(', ') + '</li>';
                                }
                            }
                            errorMessageHtml += '</ul>';
                            // エラーメッセージをHTMLに追加するために表示エリアを探す
                            // もし存在しなければ作成する
                            var errorDiv = $('#errorMessages');
                            if (errorDiv.length === 0) {
                                $('form').prepend('<div id="errorMessages" style="color: red;"></div>');
                                errorDiv = $('#errorMessages');
                            }
                            errorDiv.html(errorMessageHtml).show();
                        } else {
                            // その他のエラー
                            handleAjaxError(xhr, status, error)
                        }
                    }
                });
            } else if (page === 'completeForm') {
                $('main').html(completeFormHTML);
                updateHeader('出荷先登録完了');
                attachEvents();
                // 完了画面から戻る操作をブロック
                history.pushState({ page: 'new' }, '', '#new');
            }
        }

        function attachEvents() {
            $('#toConfirm').off().click(function() {
                // 確認ボタンを押したときに値を一時保存
                tempFormData = { 
                    name: $('#name').val(),
                    address: $('#address').val(),
                    tel: $('#tel').val()
                };
                navigateTo('confirmForm');
            });

            $('#submitForm').off().click(function() {
                $.ajax({
                    url: '/shippings/store',
                    type: 'POST',
                    data: tempFormData,
                    success: function(response) {
                        navigateTo('completeForm');
                        console.log('登録完了:', response);
                    },
                    error: handleAjaxError
                });
            });

            $('#backToInput').off().click(function() {
                navigateTo('inputForm');
            });

            $('#newRegister').off().click(function() {
                navigateTo('inputForm');
            });
        }

        // ブラウザバック
        window.onpopstate = function(event) {
            if (event.state && event.state.page) {
                navigateTo(event.state.page);
            } else {
                // 完了画面からのブラウザバック操作で新規入力画面へ
                navigateTo('inputForm');
            }
        };

        function handleAjaxError(xhr, status, error) {
            // エラーのHTTPステータスコードとテキストをコンソールに表示
            console.error('Error Status:', xhr.status);
            console.error('Status Text:', xhr.statusText);
            // バリデーションエラーの詳細をコンソールに表示
            if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                console.error('Validation Errors:', xhr.responseJSON.errors);
                alert('フォームにエラーがあります。入力を確認してください。');
            } else {
                console.error('Error Response:', xhr.responseText);
                alert('エラーが発生しました。詳細はコンソールを確認してください。');
            }
        }

        // 初期表示
        $(document).ready(function() {
            navigateTo('inputForm');
        });
    </script>

</x-app-layout>


