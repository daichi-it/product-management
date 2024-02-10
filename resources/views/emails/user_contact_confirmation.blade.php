<!DOCTYPE html>
<html>
<head>
    <title>お問い合わせ受付完了</title>
</head>
<body>
    <h1>{{ $details['name'] }} 様、お問い合わせありがとうございます。</h1>
    <p>以下の内容でお問い合わせを受け付けました。</p>
    <ul>
        <li>お名前: {{ $details['name'] }}</li>
        <li>メールアドレス: {{ $details['email'] }}</li>
        <li>電話番号: {{ $details['tel'] }}</li>
        <li>問い合わせ内容: {{ $details['message'] }}</li>
    </ul>
</body>
</html>