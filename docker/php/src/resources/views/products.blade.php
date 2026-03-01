<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachtechフリマ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">
</head>
<body>
    <header class="header">
        <div class="header__inner flex-row">
            <div class="header__logo">
                <img src="{{ asset('storage/flea-market-image/coachtech-logo.png') }}" alt="" class="logo">
            </div>
            <div class="search">
                <form action="{{ url()->current() }}" method="get" class="search__form">
                    <input type="text" name="keyword" value="{{ request('keyword') }}" class="search__input" placeholder="なにをお探しですか？">
                    @if(request()->filled('mylist'))
                    <input type="hidden" name="mylist" value="1">
                    @endif
                </form>
            </div>
            <div class="function">
                @guest
                <div class="login">
                    <a href="/login" class="login__button function-decoration">ログイン</a>
                </div>
                @endguest
                @auth
                <form action="{{ route('logout') }}" method="post" class="logout__form">
                    @csrf
                    <button class="logout__button function-decoration">
                        ログアウト
                    </button>
                </form>
                @endauth
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
        <div class="navigation__inner">
            <div class="navigation__wrap">
                <div class="nav__pickup">
                    <a href="{{ route('products.list', request()->except('mylist')) }}" class="{{ request()->has('mylist') ? 'inactive' : 'active' }}">
                        <span class="pickup">おすすめ</span>
                    </a>
                </div>
                <div class="nav__my-list">
                    <a href="{{ auth()->check() ? route('products.list', request()->query() + ['mylist' => 1]) : route('login') }}" class="{{ request()->has('mylist') ? 'active' : 'inactive' }}">
                        <span class="my-list">マイリスト</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="underline"></div>
        <div class="main__inner">
            @foreach ($products as $product)
            <a href="{{ route('product.detail', $product->id) }}" class="products__link">
                <input type="hidden" name="item_id" value="{{ $product->id }}">
                <div class="products">
                    <div class="product__image">
                        @if ($product->is_sold)
                        <div class="sold-overlay">SOLD</div>
                        @endif
                        <img src="{{ asset('storage/' . $product->img_url) }}" alt="" class="image">
                    </div>
                    <div class="product__name">
                        <span class="name">{{ $product->name }}</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </main>
</body>
</html>
