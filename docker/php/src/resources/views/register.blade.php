<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
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
        <div class="register__inner">
            <div class="register__header">
                <h1 class="register__text">会員登録</h1>
            </div>
            <div class="register-form__inner">
                <form action="{{ route('register') }}" method="post" class="register__form">
                    @csrf
                    <div class="flex">
                        <div class="form-input__inner">
                            <h3 class="input__text">ユーザー名</h3>
                            <input type="name" name="name" value="{{ old('name') }}" class="form__input">
                        </div>
                        <div class="form__error">
                            @error('name')
                                <li class="error__message">{{ $message }}</li>
                            @enderror
                        </div>
                        <div class="form-input__inner">
                            <h3 class="input__text">メールアドレス</h3>
                            <input type="email" name="email" value="{{ old('email') }}" class="form__input">
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
                        <div class="form-input__inner">
                            <h3 class="input__text">確認用パスワード</h3>
                            <input type="password" name="password_confirmation" class="form__input">
                        </div>
                        <div class="form__error">
                            @error('password_confirmation')
                                <li>{{ $message }}</li>
                            @enderror
                        </div>
                        <div class="register-button__inner">
                            <button class="register__button">登録する</button>
                        </div>
                    </div>
                </form>
                <div class="login__link">
                    <a href="/login" class="login-link__button">ログインはこちら</a>
                </div>
            </div>
        </div>
    </main>
</body>
</html>