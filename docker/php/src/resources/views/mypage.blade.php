<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MYPAGE</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile/mypage.css') }}">
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
        <div class="user__header">
            <div class="user__icon">
                <img src="{{ asset('storage/' . $userData->profile_image) }}" alt="" class="user-icon__image">
                <h1 class="user__name">
                    {{ $userData->name }}
                </h1>
            </div>
            <div class="profile__setting">
                <a href="{{ route('profile') }}" class="profile-setting__button">プロフィールを編集</a>
            </div>
        </div>
        <div class="border"></div>
        <div class="products__show">
            <div class="tab-menu">
                <div class="sell-products__inner">
                    <a href="{{ route('mypage', ['page' => 'sell']) }}" class="{{ $page === 'sell' ? 'active' : 'inactive' }}">出品した商品</a>
                </div>
                <div class="purchase-products__inner">
                    <a href="{{ route('mypage', ['page' => 'buy']) }}" class="{{ $page === 'buy' ? 'active' : 'inactive' }}">購入した商品</a>
                </div>
            </div>
        </div>
        <div class="main__inner">
            @if ($products->isEmpty())
                @if ($page === 'sell')
                <div class="products__empty">
                    <p class="empty__text">まだ出品した商品がありません</p>
                </div>
                @else
                <div class="products__empty">
                    <p class="empty__text">まだ購入した商品がありません</p>
                </div>
                @endif
            @else
                @foreach($products as $product)
                @php
                $displayProduct = ($page === 'sell') ? $product : $product->product;
                @endphp
                <a href="{{ route('product.detail', $displayProduct->id) }}" class="products__link">
                    <input type="hidden" name="item_id" value="{{ $product->id }}">
                    <div class="products">
                        <div class="product__image">
                            <img src="{{ asset('storage/' . $displayProduct->img_url) }}" alt="" class="image">
                        </div>
                        <div class="product__name">
                            <span class="name">{{ $displayProduct->name }}</span>
                        </div>
                    </div>
                </a>
                @endforeach
            @endif
        </div>
    </main>
</body>
</html>