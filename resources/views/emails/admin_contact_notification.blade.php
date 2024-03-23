<!DOCTYPE html>
<html>
<head>
    <title>新しいお問い合わせ通知</title>
</head>
<body>
    <h1>新しいお問い合わせがありました</h1>
    <p>以下の内容でお問い合わせがありましたので、確認してください。</p>
    <ul>
        <li>名前: {{ $details['name'] }}</li>
        <li>メールアドレス: {{ $details['email'] }}</li>
        <li>性別: {{ $details['gender'] === 'male' ? '男性' : '女性' }}</li>
        @if($details['gender'] === 'male' && isset($details['hobby']))
            <li>趣味: {{ $details['hobby'] }}</li>
        @elseif($details['gender'] === 'female' && isset($details['skill']))
            <li>特技: {{ $details['skill'] }}</li>
        @endif 
        <li>電話番号: {{ $details['tel'] }}</li>
        <li>問い合わせ内容:</li>
        <p>{{ $details['message'] }}</p>
    </ul>
    <p>これは自動送信メールです。直接このメールに返信しないようお願いします。</p>
</body>
</html>
