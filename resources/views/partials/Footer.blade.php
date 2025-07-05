<footer>
    @php
        // توصية: من الأفضل نقل هذا الكود إلى Service Provider أو Controller
        use App\Models\AdminInfo;
        $info = AdminInfo::first();
    @endphp
    <div class="container">
        <div class="footer-content">
            <div class="row">
                <div class="col-md-4">
                    <h2>{{$setting->site_name}}</h2>
                    <ul>
                        <li><a href="{{ route('store') }}">{{ __('store.footer.home') }}</a></li>
                        @guest
                        <li><a href="{{ route('login') }}">{{ __('store.footer.login') }}</a></li>
                        @endguest
                        @auth
                        <li><a href="{{ route(Auth::user()->getRedirectRoute()) }}">{{ __('store.footer.dashboard') }}</a></li>
                        <li><a href="{{ route('cart.index') }}">{{ __('store.footer.cart') }}</a></li>
                        @endauth
                    </ul>
                </div>

                <div class="col-md-4">
                    <h2>{{ __('store.footer.contact_us') }}</h2>
                    <ul>
                        <li><a href="mailto:{{$info->email}}">{{ $info->email }}</a></li>
                        <li><a href="tel:{{$info->phone}}">{{ $info->phone }}</a></li>
                        <ul class="d-flex align-items-center justify-content-center gap-2">
                            @if($info->facebook)<li><a href="{{$info->facebook}}"><i class="fa-brands fa-facebook"></i></a></li>@endif
                            @if($info->whatsapp)<li><a href="{{$info->whatsapp}}"><i class="fa-brands fa-whatsapp"></i></a></li>@endif
                            @if($info->twitter)<li><a href="{{$info->twitter}}"><i class="fa-brands fa-twitter"></i></a></li>@endif
                        </ul>
                    </ul>
                </div>

                <div class="col-md-4">
                    <h2 class="">{{ __('store.footer.payment_methods') }}</h2>
                    <div class="img-footer">
                        <img src="{{ asset('storage/images/payments.jpg') }}" alt="Payment Methods">
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>