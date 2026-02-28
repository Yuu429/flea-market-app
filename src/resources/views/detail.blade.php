<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachtechフリマ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
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
                @guest
                <div class="login">
                    <a href="/login" class="login__button function-decoration">ログイン</a>
                </div>
                @endguest
                @Auth
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
        <div class="main__inner">
            <div class="grid">
                <div class="image__inner">
                    @if ($product->is_sold)
                    <div class="sold-overlay">SOLD</div>
                    @endif
                    <img src="{{ asset('storage/' . $product->img_url) }}" alt="" class="image">
                </div>
                <div class="detail__inner">
                    <div class="detail">
                        <section>
                            <div class="product-name">
                                <h1 class="product-name__output">{{ $product->name }}</h1>
                                <p class="brand-name">{{ $product->brand }}</p>
                            </div>
                            <div class="product-price">
                                <span class="yen-mark position">￥</span>
                                <span class="price">{{ number_format($product->price) }}</span>
                                <span class="tax-included position">(税込)</span>
                            </div>
                            <div class="tooltip">
                                <form class="like-form" data-product-id="{{ $product->id }}">
                                    @csrf
                                    <button type="submit" class="icon-button">
                                        <div class="icon-mark">
                                            @if($product->isLikedBy(auth()->user()))
                                            <img src="{{ asset('storage/flea-market-image/hart-logo_pink.png') }}" alt="" class="icon-image">
                                            @else
                                            <img src="{{ asset('storage/flea-market-image/hart-logo.png') }}" alt="" class="icon-image">
                                            @endif
                                        </div>
                                    </button>
                                    <span class="like-count count">
                                        {{ $product->likedUsers()->count() }}
                                    </span>
                                </form>
                                <a href="#comment" class="icon-button">
                                    <div class="icon-mark">
                                        <img src="{{ asset('storage/flea-market-image/speech-balloon.png') }}" alt="" class="icon-image">
                                    </div>
                                    <span class="comment-count count">
                                        {{ $product->comments_count }}
                                    </span>
                                </a>
                            </div>
                            <div class="purchase-procedure__inner">
                                <a href="{{ route('product.purchase', $product->id) }}" class="purchase-procedure__button">
                                    <div class="purchase-procedure">購入手続きへ</div>
                                </a>
                            </div>
                        </section>
                        <section class="description">
                            <div class="product-description">
                                <div class="product-description__header">
                                    <h2>
                                        商品説明
                                    </h2>
                                </div>
                                <div class="product-color">
                                    <span class="color-text">カラー：</span>
                                </div>
                                <div class="product-description__container">
                                    <pre class="description-text">{{ $product->description }}</pre>
                                </div>
                            </div>
                        </section>
                        <section class="information">
                            <div class="product-information">
                                <div class="product-information__header">
                                    <h2>
                                        商品の情報
                                    </h2>
                                </div>
                                <div class="product-category">
                                    <h4 class="category-text">カテゴリー</h4>
                                    <div class="category-list">
                                        @foreach($product->categories as $category)
                                        <span class="category">{{ $category->name }}</span>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="product-condition">
                                    <h4 class="condition-text">商品の状態</h4>
                                    <span class="condition">{{ $displayCondition }}</span>
                                </div>
                            </div>
                        </section>
                        <section class="comment">
                            <div class="comment__inner" id="comment">
                                <form action="{{ route('comments.store', $product) }}" method="post" class="comment-form">
                                    @csrf
                                    <div class="comment__header">
                                        <h2>コメント({{ $product->comments_count }})</h2>
                                    </div>
                                    @foreach ($product->comments as $comment)
                                    <div class="user">
                                        <div class="user-icon">
                                            <img src="{{ asset('storage/' . $comment->user->profile_image) }}" alt="" class="user-image">
                                        </div>
                                        <div class="user-name">
                                            <p>{{ $comment->user->name }}</p>
                                        </div>
                                    </div>
                                    <div class="comment-section__inner">
                                        <div class="comment-section">{{ $comment->comment }}</div>
                                    </div>
                                    @endforeach
                                    <div class="comment-enter__inner">
                                        <div class="comment-enter__text">
                                            <span class="comment__text">商品へのコメント</span>
                                        </div>
                                        <div class="comment-enter__field">
                                            <textarea name="comment" id="" class="comment__field"></textarea>
                                        </div>
                                        <div class="form__error">
                                            @error('comment')
                                                <li>{{ $message }}</li>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="comment-submit__inner">
                                        <button type="submit" class="comment-submit__button">
                                            <div class="comment-submit">
                                                コメントを送信する
                                            </div>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        document.querySelectorAll('.like-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const productId = form.dataset.productId;
                const token = form.querySelector('input[name="_token"]').value;

                fetch(`/item/${productId}/like`, {
                    method: 'post',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    const button = form.querySelector('.icon-mark');
                    const countEl = form.querySelector('.like-count');

                    button.innerHTML = data.liked
                        ? '<img src="{{ asset("storage/flea-market-image/hart-logo_pink.png") }}" alt="" class="icon-image">'
                        : '<img src="{{ asset("storage/flea-market-image/hart-logo.png") }}" alt="" class="icon-image">';

                    countEl.textContent = data.likes_count;
                });
            });
        });
    </script>
</body>
</html>