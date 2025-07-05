@php
// توصية: من الأفضل نقل هذا الكود إلى View Composer أو Service Provider
use Illuminate\Support\Facades\Auth;
use App\Models\Cart\Cart;

$cartCount = 0;

if (Auth::check()) {
    $userId = Auth::id();
    $cart = Cart::where('user_id', $userId)
                ->withCount(['items as total_quantity' => function ($query) {
                    $query->select(DB::raw('SUM(quantity)'));
                }])
                ->first();
    $cartCount = $cart->total_quantity ?? 0;
}
@endphp

<style>
.custom-nav-item {
    position: relative;
    display: inline-block;
}

.custom-nav-link {
   color: var(--title-color);
cursor: pointer;
    padding: 10px; /* يمكنك تعديل التباعد حسب الحاجة */

    border-radius: 4px;
}

.custom-dropdown-menu {
    display: none;
    position: absolute;
    background-color: #fff;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 999;
    max-width: fit-content;
    border-radius: 7px;
}

.custom-dropdown-item {
    color: #333;
    padding: 12px 20px;
    font-size: 14px;
    text-decoration: none;
    display: block;
    max-width:fit-content;
}

.custom-dropdown-item:hover {
    background-color: #f9f9f9;
    border-radius: 7px;
}

.custom-nav-item.show .custom-dropdown-menu {
    display: block;
}



</style>
<nav class="navbar navbar-expand-md navbar-light bg-color-custom shadow-sm">
    <div class="container">
        <div class="navbar-brand-container">
            <img src="{{ asset('storage/'.$setting->logo) }}" alt="Logo" class="logo">
            <a class="navbar-brand titleSite" href="{{ url('/') }}">
                {{$setting->site_name}}
            </a>
        </div>
        <button class="navbar-toggler-custom" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa-solid fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <div class="d-md-flex align-items-center">
                    <li class="nav-item active">
                        <a class="nav-link link-a" href="/">{{ __('store.navbar.home') }} <span class="sr-only">{{ __('store.navbar.current') }}</span></a>
                    </li>
                    @if (Auth::user())
                    <li class="nav-item">
                        <a class="nav-link link-a" href="{{ route(Auth::user()->getRedirectRoute()) }}">{{ __('store.navbar.dashboard') }}</a>
                    </li>
                    @endif
                </div>

                @guest
                <div class="d-md-flex align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}"><i class="fa-solid fa-user"></i> </a>
                    </li>
                </div>
                @endguest

                @auth
                <div class="d-md-flex align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cart.index') }}">
                            <i class="fa-solid fa-cart-shopping"></i>
                            @if ($cartCount > 0)
                                <span class="badge">{{ $cartCount > 9 ? '9+' : $cartCount }}</span>
                            @endif
                        </a>
                    </li>

                    <li class="custom-nav-item custom-dropdown">
                        <a id="customNavbarDropdown" class="custom-nav-link custom-dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->name }}
                            <i style="font-size: 14px" class="fa-solid fa-sort-down"></i>
                        </a>
                        <div class="custom-dropdown-menu" aria-labelledby="customNavbarDropdown">
                            <a class="custom-dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                               {{ __('store.navbar.logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                </div>
                @endauth
            </ul>
        </div>
    </div>
</nav>

    <script>
     document.addEventListener('DOMContentLoaded', function() {
    const dropdown = document.getElementById('customNavbarDropdown');
    const navItem = dropdown.parentElement;

    dropdown.addEventListener('click', function(event) {
        event.preventDefault();
        navItem.classList.toggle('show');
    });

    document.addEventListener('click', function(event) {
        if (!navItem.contains(event.target)) {
            navItem.classList.remove('show');
        }
    });
});







    </script>
</nav>
