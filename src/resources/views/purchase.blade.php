<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PURCHASE</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
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
        <form action="/checkout/{{ $product->id }}" method="post">
            @csrf
            <div class="purchase__container">
                <div class="purchase__column">
                    <div class="product-purchase__inner">
                        <img src="{{ asset('storage/' . $product->img_url) }}" alt="" class="product-image">
                        <div class="product">
                            <h2 class="product__name">{{ $product->name }}</h2>
                            <span class="dollar-mark">¥</span>
                            <span class="product__price">{{ number_format($product->price) }}</span>
                        </div>
                    </div>
                    <div class="borderline"></div>
                    <div class="payment-method__inner">
                        <h3 class="payment-method__header">支払い方法</h3>
                        <div class="select-field__position">
                            <select name="payment_method" id="payment_method" class="payment-method__select">
                                <option value="" hidden>選択してください</option>
                                <option value="konbini">コンビニ払い</option>
                                <option value="card">カード払い</option>
                            </select>
                        </div>
                        @if ($errors->has('payment_method'))
                        <div class="form__error">
                            支払い方法を選択してください
                        </div>
                        @endif
                    </div>
                    <div class="borderline"></div>
                    <div class="delivery-destination__inner">
                        <div class="wrap">
                            <h3 class="delivery-destination__header">配送先</h3>
                            <a href="{{ route('address.edit', [$user->id, $product->id]) }}" class="delivery-destination__change">変更する</a>
                        </div>
                        <div class="address__form">
                            〒 <input type="text" name="postal_code" value="{{ $user->postal_code }}" class="input" readonly>
                            <br>
                            <input type="text" name="address" value="{{ $user->address }}" class="input" readonly>
                        </div>
                        <div class="form__error">
                            @error('postal_code')
                                <li>{{ $message }}</li>
                            @enderror
                            @error('address')
                                <li>{{ $message }}</li>
                            @enderror
                        </div>
                    </div>
                    <div class="borderline"></div>
                </div>
                <div class="purchase__confirmation">
                    <div class="confirmation__inner">
                        <div class="product-price__confirmation">
                            <span class="product-price__text">商品代金</span>
                            <span class="confirmation__dollar-mark">¥</span>
                            <span class="product-price__price">{{ number_format($product->price) }}</span>
                        </div>
                        <div class="middle-line"></div>
                        <div class="payment-method__confirmation">
                            <span class="payment-method__text">支払い方法</span>
                            <span id="payment-info" class="payment-method__show"></span>
                        </div>
                    </div>
                    <div class="purchase-button__inner">
                        @if ($product->is_sold)
                        <div class="sold">SOLD</div>
                        @else
                        <button type="submit" id="purchase-button" class="purchase-button__submit">
                            購入する
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </form>
    </main>
    <script>
        const select = document.getElementById('payment_method');
        const info = document.getElementById('payment-info');

        info.textContent = select.options[select.selectedIndex].text;

        select.addEventListener('change', function() {
            info.textContent = this.options[this.selectedIndex].text;
        });
    </script>
</body>
</html>