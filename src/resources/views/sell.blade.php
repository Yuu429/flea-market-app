<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SELL</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sell.css') }}">
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
                        <a href="" class="sell__button">出品</a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <main>
        <div class="sell__container">
            <div class="sell__header">
                <h1 class="sell__text">
                    商品の出品
                </h1>
            </div>
            <div class="sell-products__inner">
                <form action="{{ route('product.store') }}" method="post" class="sell-products__form" enctype="multipart/form-data">
                    @csrf
                    <div class="sell-products__image">
                        <h3 class="sell-products__image-text">
                            商品画像
                        </h3>
                        <output class="sell-products__preview" id="preview">
                        </output>
                        <div class="file_select">
                            <label for="product_image" class="sell-products__select-text">画像を選択する
                            </label>
                            <input type="file" name="img_url" id="product_image" class="sell-products__select">
                        </div>
                        <div class="form__error">
                            @error('img_url')
                                <li>{{ $message }}</li>
                            @enderror
                        </div>
                    </div>
                    <div class="underline"></div>
                    <div class="sell-products__detail">
                        <div class="sell-products__header-text">
                            <h2>商品の詳細</h2>
                        </div>
                        <div class="category__list">
                            <h3 class="category__text">カテゴリー</h3>
                            <div class="category__select">
                                @foreach($categories as $category)
                                <label for="category_{{ $category->id }}" class="category__label">
                                    <input type="checkbox" id="category_{{ $category->id }}" name="categories[]" value="{{ $category->id }}">
                                    {{ $category->name }}
                                </label>
                                @endforeach
                            </div>
                            <div class="form__error">
                                @error('categories')
                                    <li>{{ $message }}</li>
                                @enderror
                            </div>
                        </div>
                        <div class="sell-products__condition">
                            <h3 class="condition__text">商品の状態</h3>
                            <div class="select__container">
                                <select name="condition" class="condition__select">
                                    <option value="" hidden>選択してください</option>
                                    <option value="good">良好</option>
                                    <option value="excellent">目立った傷や汚れなし</option>
                                    <option value="fair">やや傷や汚れあり</option>
                                    <option value="poor">状態が悪い</option>
                                </select>
                            </div>
                            <div class="form__error">
                                @error('condition')
                                    <li>{{ $message }}</li>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="underline"></div>
                    <div class="sell-products__data">
                        <div class="sell-products__header-text">
                            <h2>商品名と説明</h2>
                        </div>
                        <div class="sell-products__name">
                            <h3>商品名</h3>
                            <input type="text" name="name" class="sell-products__input-text">
                            <div class="form__error">
                                @error('name')
                                    <li>{{ $message }}</li>
                                @enderror
                            </div>
                        </div>
                        <div class="sell-products__brand">
                            <h3>ブランド名</h3>
                            <input type="text" name="brand" class="sell-products__input-text">
                        </div>
                        <div class="sell-products__description">
                            <h3>商品の説明</h3>
                            <textarea name="description" class="sell-products__textarea"></textarea>
                            <div class="form__error">
                                @error('description')
                                    <li>{{ $message }}</li>
                                @enderror
                            </div>
                        </div>
                        <div class="sell-products__price">
                            <h3>販売価格</h3>
                            <input type="text" name="price" class="sell-products__input-text price__input">
                            <div class="form__error">
                                @error('price')
                                    <li>{{ $message }}</li>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="sell-button__inner">
                        <button class="sell-button__submit">出品する</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <script>
        document.getElementById('product_image').addEventListener('change', function(e) {
            const preview = document.getElementById('preview');
            preview.innerHTML = '';

            const file = e.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'reader_file';
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    </script>
</body>
</html>