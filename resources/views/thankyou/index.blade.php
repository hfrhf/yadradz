{{--
    افترض أن هذا الملف هو: resources/views/thankyou.blade.php
    وتأكد من أن المتحكم الذي يعرض هذه الصفحة يمرر متغيراً اسمه $order
    مثال للمتحكم:
    public function thankyou($order_code) {
        $order = CustomerOrders::where('order_code', $order_code)->with('product')->firstOrFail();
        return view('thankyou', compact('order'));
    }
--}}

@extends('base')

{{-- استخدام دالة الترجمة لعنوان الصفحة --}}
@section('title', trans('store.thank.title'))

@section('content')
<div class="parent-page-content">
    <div class="container my-5 flex-complet-center" style="min-height: 60vh;">
        <div class="login-card" style="max-width: 600px; width: 100%;">
            <div class="logo-container">
                <i class="fas fa-check-circle" style="font-size: 80px; color: var(--button-color);"></i>
            </div>

            <div class="login-body">
                {{-- استخدام دالة الترجمة للعنوان الرئيسي --}}
                <h2 class="text-success mb-4 extrabold" style="font-size: 32px; color: var(--button-color);">
                    🎉 {{ trans('store.thank.heading') }}
                </h2>
                <p class="lead regular" style="font-size: 18px; color: var(--primary-color); margin-bottom: 30px;">
                    {{-- استخدام دالة الترجمة للرسالة --}}
                    {{ trans('store.thank.message') }}<br>
                    {{-- استخدام دالة الترجمة لنص رقم الطلب --}}
                    {{ trans('store.thank.order_number') }} <span class="bold">#{{ $order->order_code ?? request('order_code') }}</span>
                </p>

                <div class="flex-complet-center" style="gap: 15px; flex-wrap: wrap;">
                    {{-- استخدام دالة الترجمة لنص زر العودة للصفحة الرئيسية --}}
                    <a href="{{ url('/') }}" class="btn-p" style="min-width: 200px;">
                        {{ trans('store.thank.back_home') }}
                    </a>
                    {{-- استخدام دالة الترجمة لنص زر تصفح المنتجات --}}
                    <a href="{{ route('store') }}" class="btn-card-buy" style="min-width: 200px;">
                        {{ trans('store.thank.browse_products') }}
                    </a>
                </div>

                <div class="mt-4" style="border-top: 1px solid #eee; padding-top: 20px;">
                    <p class="regular" style="font-size: 16px; color: var(--primary-color);">
                        {{-- استخدام دالة الترجمة لسؤال الاستفسار ورابط التواصل --}}
                        {{ trans('store.thank.any_questions') }} <a href="{{ url('/') }}" style="color: var(--button-color);" class="bold">{{ trans('store.thank.contact_us') }}</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- =================================================================
     أكواد تتبع حدث الشراء - Purchase Event Tracking Scripts
================================================================== --}}
@push('scripts')

{{--
    استخدام @push('scripts') هو طريقة جيدة في Laravel لإضافة أكواد جافاسكريبت
    إلى القالب الرئيسي. تأكد من وجود @stack('scripts') في القالب الرئيسي قبل إغلاق </body>.
    إذا لم يكن موجوداً، يمكنك وضع هذا الكود مباشرة في نهاية الملف.
--}}

{{-- التأكد من أن متغير activeTrackers موجود --}}
@if(isset($activeTrackers))
<script>
    // --- بيانات الطلب للتتبع ---
    const orderData = {
        value: {{ $order->total_price ?? 0 }},
        currency: 'DZD', // <-- غيّر العملة هنا إذا لزم الأمر
        content_name: '{{ $order->product->name ?? 'Product Name' }}',
        content_ids: ['{{ $order->product->id ?? '0' }}'],
        content_type: 'product',
        num_items: {{ $order->quantity ?? 1 }}
    };

    // --- Meta Pixel (Facebook) Purchase Event ---
    @if(isset($activeTrackers['facebook']) && $activeTrackers['facebook']->isNotEmpty())
        if (typeof fbq === 'function') {
            fbq('track', 'Purchase', {
                value: orderData.value,
                currency: orderData.currency,
                content_ids: orderData.content_ids,
                content_type: orderData.content_type,
                content_name: orderData.content_name,
                num_items: orderData.num_items
            });
        }
    @endif

    // --- TikTok Pixel Purchase Event ---
    @if(isset($activeTrackers['tiktok']) && $activeTrackers['tiktok']->isNotEmpty())
        if (typeof ttq === 'object' && ttq) {
            ttq.track('CompletePayment', { // أو 'PlaceAnOrder'
                value: orderData.value,
                currency: orderData.currency,
                content_id: orderData.content_ids[0],
                content_type: orderData.content_type,
                content_name: orderData.content_name,
                quantity: orderData.num_items
            });
        }
    @endif

    // --- Google Analytics (GA4) Purchase Event ---
    @if(isset($activeTrackers['ga']) && $activeTrackers['ga']->isNotEmpty())
        if (typeof gtag === 'function') {
            gtag('event', 'purchase', {
                transaction_id: '{{ $order->order_code }}',
                value: orderData.value,
                currency: orderData.currency,
                items: [{
                    item_id: orderData.content_ids[0],
                    item_name: orderData.content_name,
                    quantity: orderData.num_items,
                    price: {{ $order->product->price ?? 0 }} // سعر الوحدة الواحدة
                }]
            });
        }
    @endif

    // --- Google Tag Manager (GTM) Purchase Event ---
    // إذا كنت تستخدم GTM، فمن الأفضل إرسال الأحداث من خلاله بدلاً من GA4 مباشرة
    @if(isset($activeTrackers['gtm']) && $activeTrackers['gtm']->isNotEmpty())
        if (typeof dataLayer === 'object') {
            dataLayer.push({ ecommerce: null });  // Clear the previous ecommerce object
            dataLayer.push({
                event: 'purchase',
                ecommerce: {
                    transaction_id: '{{ $order->order_code }}',
                    value: orderData.value,
                    currency: orderData.currency,
                    items: [{
                        item_id: orderData.content_ids[0],
                        item_name: orderData.content_name,
                        quantity: orderData.num_items,
                        price: {{ $order->product->price ?? 0 }}
                    }]
                }
            });
        }
    @endif

</script>
@endif
@endpush