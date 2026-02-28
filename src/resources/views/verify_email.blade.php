<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VERIFIED</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/verified_email.css') }}">
</head>
<body>
    <header class="header">
        <div class="header__inner flex-row">
            <div class="header__logo">
                <img src="{{ asset('storage/flea-market-image/coachtech-logo.png') }}" alt="" class="logo">
            </div>
        </div>
    </header>
    <main>
        <div class="verify__container">
            <div class="verify__text">
                <h3>登録していただいたメールアドレスに認証メールを送付しました。
                <br>
                メール認証を完了してください。
                </h3>
            </div>
            <div class="verify__button">
                <a href="{{ URL::temporarySignedRoute(
                'verification.verify',
                now()->addMinutes(60),
                ['id' => auth()->id(), 'hash' => sha1(auth()->user()->email)]
                ) }}" target="_blank" class="profile__transition">認証はこちらから</a>
            </div>
            <div class="resend__container">
                <form action="{{ route('verification.send') }}" method="post" class="resend">
                    @csrf
                    <button class="resend__button">認証メールを再送する</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>