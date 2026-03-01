<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
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
        <div class="login__inner">
            <div class="login__header">
                <h1 class="login__text">ログイン</h1>
            </div>
            <div class="login-form__inner">
                <form action="{{ route('login') }}" method="post" class="login__form">
                    @csrf
                    <div class="flex">
                        <div class="form-input__inner">
                            <h3 class="input__text">メールアドレス</h3>
                            <input type="email" name="email" class="form__input">
                        </div>
                        <div class="form__error">
                            @error('email')
                                <li>{{ $message }}</li>
                            @enderror
                        </div>
                        <div class="form-input__inner">
                            <h3 class="input__text">パスワード</h3>
                            <input type="password" name="password" class="form__input">
                        </div>
                        <div class="form__error">
                            @error('password')
                                <li>{{ $message }}</li>
                            @enderror
                        </div>
                        <div class="login-button__inner">
                            <button class="login__button">ログインする</button>
                        </div>
                    </div>
                </form>
                <div class="register__link">
                    <a href="/register" class="register-link__button">会員登録はこちら</a>
                </div>
            </div>
        </div>
    </main>
</body>
</html>