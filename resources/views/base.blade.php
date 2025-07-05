<!DOCTYPE html>
<html lang="{{ $currentLocale }}" dir="{{ $direction }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link rel="shortcut icon" href={{asset('storage/'.$setting->logo)}} type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    @if ($direction === 'rtl')
        <link rel="stylesheet" href="{{ asset('dir/rtl.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('dir/ltr.css') }}">
    @endif

    <!-- Scripts -->
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('style.css')}}" >
    <title>{{$setting->site_name}} | @yield('title')</title>

    <!-- =================================================================
         أكواد تتبع التسويق - Marketing Tracker Scripts
    ================================================================== -->
    @if(isset($activeTrackers))

        {{-- Google Tag Manager (GTM) --}}
        @if(isset($activeTrackers['gtm']) && $activeTrackers['gtm']->isNotEmpty())
            @foreach($activeTrackers['gtm'] as $tracker)
            <!-- Google Tag Manager -->
            <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','{{ $tracker->identifier }}');</script>
            <!-- End Google Tag Manager -->
            @endforeach
        @endif

        {{-- Google Analytics (GA4) --}}
        @if(isset($activeTrackers['ga']) && $activeTrackers['ga']->isNotEmpty())
            @foreach($activeTrackers['ga'] as $tracker)
            <!-- Google tag (gtag.js) -->
            <script async src="https://www.googletagmanager.com/gtag/js?id={{ $tracker->identifier }}"></script>
            <script>
              window.dataLayer = window.dataLayer || [];
              function gtag(){dataLayer.push(arguments);}
              gtag('js', new Date());
              gtag('config', '{{ $tracker->identifier }}');
            </script>
            @endforeach
        @endif

        {{-- Meta Pixel (Facebook) --}}
        @if(isset($activeTrackers['facebook']) && $activeTrackers['facebook']->isNotEmpty())
            <!-- Meta Pixel Code -->
            <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
            @foreach($activeTrackers['facebook'] as $tracker)
              fbq('init', '{{ $tracker->identifier }}');
            @endforeach
            fbq('track', 'PageView');
            </script>
            @foreach($activeTrackers['facebook'] as $tracker)
            <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id={{ $tracker->identifier }}&ev=PageView&noscript=1"
            /></noscript>
            @endforeach
            <!-- End Meta Pixel Code -->
        @endif

        {{-- TikTok Pixel --}}
        @if(isset($activeTrackers['tiktok']) && $activeTrackers['tiktok']->isNotEmpty())
             <!-- TikTok Pixel Code -->
            <script>
                !function (w, d, t) {
                  w.TiktokAnalyticsObject=t;var ttq=w[t]=w[t]||[];ttq.methods=["page","track","identify","instances","debug","on","off","once","ready","alias","group","enableCookie","disableCookie"],ttq.setAndDefer=function(t,e){t[e]=function(){t.push([e].concat(Array.prototype.slice.call(arguments,0)))}};for(var i=0;i<ttq.methods.length;i++)ttq.setAndDefer(ttq,ttq.methods[i]);ttq.instance=function(t){for(var e=ttq._i[t]||[],n=0;n<ttq.methods.length;n++)ttq.setAndDefer(e,ttq.methods[n]);return e},ttq.load=function(e,n){var i="https://analytics.tiktok.com/i18n/pixel/events.js";ttq._i=ttq._i||{},ttq._i[e]=[],ttq._i[e].TikTokAnalyticsObject=t;var o=n&&n.partner;o&&(i=i+"?partner="+o);var a=d.createElement("script");a.type="text/javascript",a.async=!0,a.src=i+"?sdkid="+e+"&lib="+t;var c=d.getElementsByTagName("script")[0];c.parentNode.insertBefore(a,c)};
                  @foreach($activeTrackers['tiktok'] as $tracker)
                  ttq.load('{{ $tracker->identifier }}');
                  @endforeach
                  ttq.page();
                }(window, document, 'ttq');
            </script>
            <!-- End TikTok Pixel Code -->
        @endif

    @endif
    <!-- =================================================================
         نهاية أكواد تتبع التسويق
    ================================================================== -->
</head>
<body>

    {{-- Google Tag Manager (noscript) - يجب أن يكون مباشرة بعد فتح وسم الـ body --}}
    @if(isset($activeTrackers['gtm']) && $activeTrackers['gtm']->isNotEmpty())
        @foreach($activeTrackers['gtm'] as $tracker)
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $tracker->identifier }}"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
        @endforeach
    @endif

    <!-- Inline CSS to set dynamic colors -->
    <div id="app">
        {{-- Rest of your body content --}}
        @if ($setting)
        <style>
             :root {
            --primary-color: {{ $siteColors->primary_color}};
            --footer-color: {{ $siteColors->footer_color}};
            --title-color: {{ $siteColors->title_color}};
            --text-color: {{ $siteColors->text_color}};
            --button-color: {{ $siteColors->button_color}};
            --price-color: {{ $siteColors->price_color }};
            --navbar-color: {{ $siteColors->navbar_color }};
            --background-opacity:{{ $setting->background_opacity }};
            --opacity-prc:{{ $setting->opacity }};
        }
        </style>
        @else
        <style>
             :root {
                 --footer-color:#012851  ;
                 --primary-color:#054A91 ;
                 --title-color:#303036 ;
                 --text-color:#FAFAFA ;
                 --button-color:#D90368 ;
                 --price-color:#27AE60 ;
                 --navbar-color: #ffffff;
            }
        </style>
        @endif

        <div class="content">
            @include('partials.nav')
            @php
                $landing=!Route::is('store')
            @endphp
            <div @class(['container mt-4' => $landing])>
                    <div class="parent-page-content">@yield('content')</div>
            </div>
            <div class="mt-5">
                @include('partials.Footer')
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    </div>
    @stack('scripts')
</body>
</html>
