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
        <li>性別: {{ $details['gender'] === 'male' ? '男性' : '女性' }}</li>
        @if($details['gender'] === 'male' && isset($details['hobby']))
            <li>趣味: {{ $details['hobby'] }}</li>
        @elseif($details['gender'] === 'female' && isset($details['skill']))
            <li>特技: {{ $details['skill'] }}</li>
        @endif
        <li>メールアドレス: {{ $details['email'] }}</li>
        <li>電話番号: {{ $details['tel'] }}</li>
        <li>問い合わせ内容:</li>
        <p>{{ $details['message'] }}</p>
    </ul>
</body>
</html>