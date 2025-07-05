
@extends('base')
@section('title', __('store.store_index.title'))

@if ($setting)
<style>
    .landing {
        background-image: url("{{ asset('storage/' . $setting->header_image) }}");
    }
</style>
@else
<style>
    .landing {
        background-image: url('{{ asset("images/com.jpg") }}');
    }
</style>
@endif

@section('content')
<div class="landing">
    <div class="hero">
        <div class="hero-text text-center">
            <h1 class="text-center hero-title">{{$setting->site_name}}</h1>
            <p class="hero-subtitle">{{$setting->content}}</p>
            <div class="hero-cta">
                <button class="btn-w">{{ __('store.store_index.shop_now') }}</button>
            </div>
        </div>
    </div>
</div>

<div class="container mt-15">
    <h1 class="title-section">{{ __('store.store_index.top_selling') }}</h1>
    @if($topSellingProducts->isEmpty())
    <div class="empty-products">
        <p class="">{{ __('store.store_index.no_top_selling_products') }}</p>
    </div>
    @else
    <div class="cards-most">
        @foreach($topSellingProducts as $product)
        <div class="product-card">
            <img class="product-card-img" src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}">
            <div class="product-card-body">
                <div class="pc-title">
                    <h5 class="product-card-title">{{$product->name}}</h5>
                </div>
                <div class="pct">
                    <p class="product-card-text">{{ Str::limit(strip_tags($product->description), 30) }}</p>
                </div>
                <div class="cards-info d-flex justify-content-between align-items-center">
                    <div>
                        <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-link">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </button>
                        </form>
                    </div>
                    <div>
                        <span class="cards-price">{{$product->price}} دج</span>
                    </div>
                </div>
                <div class="btn-cards">
                    <a class="btn-p btn-card" href="{{ route('store.show', $product->id) }}">{{ __('store.store_index.show_product') }}</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <h1 class="title-section">{{ __('store.store_index.title') }}</h1>
    <div class="page-products-section">
        <div class="row">
            <div id="filter" class="filter col-md-12 col-lg-3">
                <h3 class="title-filter">{{ __('store.store_index.search') }}</h3>
                <form method="get">
                    <div class="mb-3">
                        <label for="name" class="form-label text-filter">{{ __('store.store_index.product_name_label') }}</label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            class="form-control input-filter"
                            placeholder="{{ __('store.store_index.product_name_placeholder') }}"
                            aria-describedby="helpId"
                            value="{{ Request::input('name') }}"
                        />
                    </div>
                    <h5 class="text-filter">{{ __('store.store_index.categories') }}</h5>

                    @foreach ($categories as $category)
                    <div class="form-check mb-3">
                        @php
                            $checked = false;
                            if (Request::input('categories') !== null) {
                                $checked = in_array($category->id, Request::input('categories'));
                            }
                        @endphp
                        <input @checked($checked) value="{{$category->id}}" type="checkbox" name="categories[]" class="form-check-input" />
                        <label class="form-check-label text-check">{{$category->name}}</label>
                    </div>
                    @endforeach

                    <div class="min-max">
                        <div class="mb-3">
                            <label for="max" class="form-label text-filter">{{ __('store.store_index.max_price_label') }}</label>
                            <input
                                type="number"
                                name="max"
                                id="max"
                                class="form-control input-filter"
                                placeholder="{{ __('store.store_index.max_price_placeholder') }}"
                                aria-describedby="helpId"
                                value="{{ Request::input('max') }}"
                                min="0"
                            />
                        </div>
                        <div class="mb-3">
                            <label for="min" class="form-label text-filter">{{ __('store.store_index.min_price_label') }}</label>
                            <input
                                type="number"
                                name="min"
                                min="0"
                                id="min"
                                class="form-control input-filter"
                                placeholder="{{ __('store.store_index.min_price_placeholder') }}"
                                aria-describedby="helpId"
                                value="{{ Request::input('min') }}"
                            />
                        </div>
                    </div>
                    <div class="text-center">
                        <input type="submit" class="btn-filter" value="{{ __('store.store_index.search_button') }}" />
                    </div>
                </form>
            </div>

            <div @class(['cards-section col-md-12 col-lg-9', 'd-flex justify-content-center align-items-center' => $products->isEmpty()])>
                @if($products->isEmpty())
                <div class="empty-products w-100">
                    <p class="">{{ __('store.store_index.no_products') }}</p>
                </div>
                @else
                <div id="cards" class="cards justify-content-center align-items-center">
                    @foreach ($products as $product)
                    <div class="product-card">
                        <img class="product-card-img" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                        <div class="product-card-body">
                            <h5 class="product-card-title">{{ $product->name }}</h5>
                            <div class="pct">
                                <p class="product-card-text">{{ Str::limit(strip_tags($product->description), 30) }}</p>
                            </div>
                            <div class="cards-info d-flex justify-content-between align-items-center">
                                <div>
                                    <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-link">
                                            <i class="fa-solid fa-cart-shopping"></i>
                                        </button>
                                    </form>
                                </div>
                                <div>
                                    <span class="cards-price">{{ $product->price }} دج</span>
                                </div>
                            </div>
                            <div class="btn-cards">
                                <a class="btn-p btn-card" href="{{ route('store.show', $product->id) }}">{{ __('store.store_index.show_product') }}</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
    {{ $products->links() }}
</div>

<script>
    document.querySelector('.btn-w').addEventListener('click', function() {
        document.getElementById('filter').scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
</script>
@endsection
