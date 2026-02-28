<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDIT</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/edit.css') }}">
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
        <div class="edit__container">
            <div class="address-edit__header">
                <h1 class="address-edit__text">住所の変更</h1>
            </div>
            <div class="address-edit__form">
                <form action="{{ route('address.patch', $productId) }}" method="post" class="edit__form">
                    @csrf
                    @method('patch')
                    <div class="address-data__inner">
                        <h3 class="postal-code__text">
                            郵便番号
                        </h3>
                        <input type="text" name="postal_code" value="{{ $user->postal_code }}" class="address-data__input">
                        <div class="form__error">
                            @error('postal_code')
                                <li>{{ $message }}</li>
                            @enderror
                        </div>
                    </div>
                    <div class="address-data__inner">
                        <h3 class="address__text">
                            住所
                        </h3>
                        <input type="text" name="address" value="{{ $user->address }}" class="address-data__input">
                        <div class="form__error">
                            @error('address')
                                <li>{{ $message }}</li>
                            @enderror
                        </div>
                    </div>
                    <div class="address-data__inner">
                        <h3 class="building__text">
                            建物名
                        </h3>
                        <input type="text" name="building" value="{{ $user->building }}" class="address-data__input">
                    </div>
                    <div class="address-data__edit-button">
                        <button class="edit-button__submit">更新する</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>