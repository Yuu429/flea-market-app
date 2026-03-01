<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile/profile.css') }}">
</head>
<body>
    <header class="header">
        <div class="header__inner flex-row">
            <div class="header__logo">
                <img src="{{ asset('storage/flea-market-image/coachtech-logo.png') }}" alt="" class="logo">
            </div>
            <div class="search">
                <form action="{{ route('products.list') }}" method="get" class="search__form">
                    <input type="text" name="keyword" value="{{ request('keyword') }}" class="search__input" placeholder="なにをお探しですか？">
                </form>
            </div>
            <div class="function">
                <form action="{{ route('logout') }}" method="post" class="logout__form">
                    @csrf
                    <button class="logout__button function-decoration">
                        ログアウト
                    </button>
                </form>
                <div class="my-page">
                    <a href="{{ route('mypage') }}" class="my-page__button function-decoration">マイページ</a>
                </div>
                <div class="sell__inner">
                    <div class="sell">
                        <a href="{{ route('product.sell') }}" class="sell__button">出品</a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <main>
        <div class="main__inner">
            <div class="profile__header">
                <h1 class="header__text">
                    プロフィール設定
                </h1>
            </div>
            <div class="user-profile__inner">
                <form action="{{ route('profile.store') }}" method="post" class="user-profile__form" enctype="multipart/form-data">
                    @csrf
                    <div class="user-icon__inner">
                        <output class="user-icon__image" id="list"></output>
                        <label for="product_image" class="custom__select">画像を選択する</label>
                        <input type="file" onchange="previewImage(event)" name="profile_image" id="product_image" value="{{ $userData->profile_image }}" class="icon-image__select">
                        <div class="form__error">
                            @error('profile_image')
                                <li>{{ $message }}</li>
                            @enderror
                        </div>
                    </div>
                    <div class="form-input__inner">
                        <h3 class="input__text">ユーザー名</h3>
                        <input type="name" name="name" class="form__input" value="{{ $userData->name }}">
                        <div class="form__error">
                            @error('name')
                                <li>{{ $message }}</li>
                            @enderror
                        </div>
                    </div>
                    <div class="form-input__inner">
                        <h3 class="input__text">郵便番号</h3>
                        <input type="text" name="postal_code" inputmode="numeric" pattern="[0-9\-]*" autocomplete="postal-code" class="form__input" value="{{ $userData->postal_code }}">
                        <div class="form__error">
                            @error('postal_code')
                                <li>{{ $message }}</li>
                            @enderror
                        </div>
                    </div>
                    <div class="form-input__inner">
                        <h3 class="input__text">住所</h3>
                        <input type="text" name="address" class="form__input" value="{{ $userData->address }}">
                        <div class="form__error">
                            @error('address')
                                <li>{{ $message }}</li>
                            @enderror
                        </div>
                    </div>
                    <div class="form-input__inner">
                        <h3 class="input__text">建物名</h3>
                        <input type="text" name="building" class="form__input" value="{{ $userData->building }}">
                    </div>
                    <div class="register-button__inner">
                        <button class="register__button">更新する</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <script>
        function initializeFiles() {
            var list = document.getElementById('list');
            list.innerHTML = '';

            var currentIcon = "{{ auth()->user()->profile_image ? asset('storage/' . auth()->user()->profile_image) : asset('storage/flea-market-image/default_icon.png') }}";
            var div = document.createElement('div');
            div.className = 'reader_file';
            div.innerHTML = '<img class="reader_image" src="' + currentIcon + '" />';
            list.appendChild(div);
        }

        document.getElementById('product_image').onchange = function(event){
            var list = document.getElementById('list');
            list.innerHTML = '';

            var files = event.target.files;

            for (var i = 0, f; f = files[i]; i++) {
                var reader = new FileReader;
                reader.readAsDataURL(f);

                reader.onload = (function(theFile) {
                    return function (e) {
                        var div = document.createElement('div');
                        div.className = 'reader_file';
                        div.innerHTML = '<img class="reader_image" src="' + e.target.result + '" />';
                        list.appendChild(div);
                    }
                })(f);
            }
        };

        window.onload = initializeFiles;
    </script>
</body>
</html>