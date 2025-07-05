@extends('base')
@section('title', __('store.store_show.title'))

@section('content')
<style>
      /* حاوية مربعات الألوان */
      .color-swatches-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 5px;
    }

    /* تصميم مربع اللون الواحد */
    .color-swatch {
        position: relative;
        cursor: pointer;
    }

    /* إخفاء زر الراديو الأصلي */
    .color-swatch input[type="radio"] {
        opacity: 0;
        position: absolute;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }

    /* تصميم مربع اللون الظاهر للمستخدم */
    .color-swatch .swatch-visual {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        border: 2px solid #e0e0e0;
        transition: all 0.2s ease-in-out;
        display: block;
    }

    /* تغيير شكل المربع عند مرور الماوس عليه */
    .color-swatch:hover .swatch-visual {
        transform: scale(1.1);
        border-color: #aeaeae;
    }

    /* تغيير شكل المربع عند اختياره (أهم جزء) */
    .color-swatch input[type="radio"]:checked + .swatch-visual {
        border-color: #6f42c1; /* لون مميز للإطار */
        transform: scale(1.1);
        box-shadow: 0 0 0 3px rgba(111, 66, 193, 0.3); /* إضافة هالة حول اللون المختار */
    }

    /* --- Start: New Styles for Size Swatches --- */

    /* حاوية مربعات المقاسات */
    .size-swatches-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 5px;
    }

    /* تصميم مربع المقاس الواحد */
    .size-swatch {
        position: relative;
        cursor: pointer;
    }

    /* إخفاء زر الراديو الأصلي */
    .size-swatch input[type="radio"] {
        opacity: 0;
        position: absolute;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }

    /* تصميم مربع المقاس الظاهر للمستخدم */
    .size-swatch .swatch-visual {
        min-width: 45px;
        height: 45px;
        padding: 0 15px;
        border-radius: 8px;
        border: 2px solid #e0e0e0;
        transition: all 0.2s ease-in-out;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 500;
        background-color: #ffffff;
        color: #333;
    }

    /* تغيير شكل المربع عند مرور الماوس عليه */
    .size-swatch:hover .swatch-visual {
        border-color: #aeaeae;
    }

    /* تغيير شكل المربع عند اختياره */
    .size-swatch input[type="radio"]:checked + .swatch-visual {
        border-color: #6f42c1;
        background-color: #6f42c1;
        color: #ffffff;
    }
    /* --- End: New Styles for Size Swatches --- */

</style>
@if (session('error'))
<div class="alert alert-danger" role="alert">
    {{ session('error') }}
</div>
@endif
@if (session('success'))
<div class="alert alert-success" role="alert">
    {{ session('success') }}
</div>
@endif

<div class="product-container">
    <div class="flex-complet-between">

            <div class="shipp-price-compare">
                <h4 class="title-product">{{$product->name}} </h4>

            </div>






        <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" value="1">
            <button type="submit" class="btn-add">{{ __('store.store_show.add_to_cart') }}</button>
        </form>
    </div>
    <div class="price-display-5 mt-3 ">

        @if ($product->compare_price && $product->compare_price > 0 )
        <div class="save-amount">-{{ round(($product->compare_price - $product->price) / ($product->compare_price) * 100) }}%</div>
        @endif
        <span class="product-price-original">{{$product->price}} دج </span>
        <span class="product-price-compare" style="text-decoration: line-through;">{{$product->compare_price}} دج</span>
        <div class="stars-five">
            <i class="fas fa-star" style="color: #FFD700;"></i>
            <i class="fas fa-star" style="color: #FFD700;"></i>
            <i class="fas fa-star" style="color: #FFD700;"></i>
            <i class="fas fa-star" style="color: #FFD700;"></i>
            <i class="fas fa-star" style="color: #FFD700;"></i>
        </div>
    </div>

    <div class="product-show">
        <div class="product-info">
            <div class="product-slider rounded-lg">
                <div class="image-top-slider">
                    <div class="product-image">
                        <img id="mainImage" src="{{asset('storage/'.$product->images[0]->image_path)}}" alt="Title">
                    </div>
                </div>
                <div class="images-dawn-slider">
                    @foreach($product->images as $image)
                    <img src="{{ asset('storage/' . $image->image_path) }}" onclick="changeImage(this)">
                    @endforeach
                </div>
            </div>
            <div class="product-description mt-5">
                <h1 class="description-product">{{ __('store.store_show.description') }}</h1>
                <div>{!! $product->description !!}</div>

            </div>
        </div>
        <div class="product-shop">
            <div class="delevry-free mb-5">
                <span class="text-">
                    @if($product->free_shipping_office && $product->free_shipping_home)

                     <span class="fs-6">
                        <x-delivery-card title="توصيل مجاني" />

                     </span>

                    @elseif($product->free_shipping_home)

                    <span class="fs-6">
                       <x-delivery-card title="توصيل مجاني إلى المنزل" />
                    </span>

                    @elseif($product->free_shipping_office)

                    <span class="fs-6" >
                     <x-delivery-card title="توصيل مجاني إلى المكتب" />
                    </span>
                    @endif
                   </span>
            </div>
            <div class="product-shop-buy mb-3">
                <h1 class="title-shop mb-3">{{ __('store.store_show.buy_product') }}</h1>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif


                <form action="{{route('customer-orders.store')}}" method="post">
                    @csrf
                    <input type='hidden' name="product_id" value="{{$product->id}}">
                    <input type="hidden" name="delivery_price" id="delivery_price_input">
                    <input type="hidden" name="total_price" id="total_price_input">
                    <input type="hidden" name="product_variation_id" id="product_variation_id_input">

                    <div class="form-group">
                        <input type="text" placeholder="{{ __('store.store_show.fullname_placeholder') }}" name="fullname" class="modern-input">
                    </div>
                    @error('fullname')
                    <div class="mt-1 mb-1"><p class="text-danger">{{$message}}</p></div>
                    @enderror
                    <div class="form-group">
                        <input type="tel" placeholder="{{ __('store.store_show.phone_placeholder') }}" name="phone" class="modern-input">
                    </div>
                    @error('phone')
                    <div class="mt-1 mb-1"><p class="text-danger">{{$message}}</p></div>
                    @enderror
                    <div class="form-group">
                        <input type="email" placeholder="{{ __('store.store_show.email_placeholder') }}" name="email" class="modern-input">
                    </div>
                  {{-- 2. استخدم هذا الكود في ملف الـ Blade الخاص بصفحة عرض المنتج --}}
<div class="attributes-section">
    @foreach ($attributes as $attribute)
        <div class="form-group mb-4">
            {{-- استخدمنا هنا localized_name لعرض الاسم حسب لغة المستخدم --}}
            <label class="form-label fw-bold">{{ $attribute->localized_name }}:</label>

            {{-- التحقق من اسم الخاصية الأساسي (العربي) --}}
            @if ($attribute->name === 'اللون')

                {{-- إذا كانت الخاصية هي "اللون"، نعرض مربعات الألوان --}}
                <div class="color-swatches-container">
                    @foreach ($attribute->values as $value)
                        <div class="color-swatch" title="{{ $value->value }}">
                            <input
                                type="radio"
                                name="attributes[{{ $attribute->id }}]"
                                id="attr_{{ $attribute->id }}_{{ $value->id }}"
                                value="{{ $value->id }}"
                                required>
                            <label class="swatch-visual" for="attr_{{ $attribute->id }}_{{ $value->id }}" style="background-color: {{ $value->value }};"></label>
                        </div>
                    @endforeach
                </div>

            @elseif ($attribute->name === 'الحجم')

                {{-- إذا كانت الخاصية هي "الحجم"، نعرض مربعات المقاسات --}}
                <div class="size-swatches-container">
                    @foreach ($attribute->values as $value)
                        <div class="size-swatch" title="{{ $value->value }}">
                            <input
                                type="radio"
                                name="attributes[{{ $attribute->id }}]"
                                id="attr_{{ $attribute->id }}_{{ $value->id }}"
                                value="{{ $value->id }}"
                                required>
                            <label class="swatch-visual" for="attr_{{ $attribute->id }}_{{ $value->id }}">{{ $value->value }}</label>
                        </div>
                    @endforeach
                </div>

            @else

                {{-- إذا كانت أي خاصية أخرى، نعرض القائمة المنسدلة التقليدية --}}
                <select name="attributes[{{ $attribute->id }}]" class="modern-input modern-select" required>
                    <option value="" disabled selected>{{ __('store.store_show.select_attribute', ['attribute' => $attribute->localized_name]) }}</option>
                    @foreach ($attribute->values as $value)
                        <option value="{{ $value->id }}">{{ $value->value }}</option>
                    @endforeach
                </select>

            @endif
        </div>
    @endforeach
</div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="form-group w-100">
                            <select class="modern-input modern-select" name="state_id" id="state-select" required>
                                <option value="" selected disabled>{{ __('store.store_show.select_state') }}</option>
                                @foreach ($shippings as $index => $shipping)

                                <option value="{{ $shipping->id }}">
                                    {{ $index + 1 }}-{{ App::getLocale() == 'ar' ? $shipping->state : $shipping->state_fr }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @error('state_id')
                        <div class="mt-1 mb-1"><p class="text-danger">{{$message}}</p></div>
                        @enderror
                        <div class="form-group w-100">
                            <select class="modern-input modern-select" name="municipality_id" id="municipality-select" disabled>
                                <option value="">{{ __('store.store_show.select_municipality') }}</option>
                            </select>
                        </div>
                        @error('municipality_id')
                        <div class="mt-1 mb-1"><p class="text-danger">{{$message}}</p></div>
                        @enderror
                    </div>
                    <div class="form-group w-100">
                        <input type="text" placeholder="{{ __('store.store_show.address_placeholder') }}" name="address" class="modern-input">
                    </div>
                    @error('address')
                    <div class="mt-1 mb-1"><p class="text-danger">{{$message}}</p></div>
                    @enderror

                    <div id="delivery-prices" class="enhanced-form-group mt-3" style="display: none;">
                        <div class="delivery-buttons-container">
                            <button type="button" class="delivery-btn hover-custom-btn-primary  btn-outline-primary" id="btn-office">
                                {!! __('store.store_show.delivery_to_office') !!} <span id="office-price"></span> دج
                            </button>
                            <button type="button" class="delivery-btn hover-custom-btn-success btn-outline-success" id="btn-home">
                                {!! __('store.store_show.delivery_to_home') !!} <span id="home-price"></span> دج
                            </button>
                        </div>
                        <input type="hidden" name="delivery_type" id="delivery_type_input">
                    </div>
                    @error('delivery_type')
                    <div class="mt-1 mb-1"><p class="text-danger">{{$message}}</p></div>
                    @enderror

                    <div class="form-group">
                        <div class="quantity-container">
                            <button type="button" class=" quantity-btn" onclick="changeQuantity(-1)">-</button>
                            <input type="number" name="quantity" id="quantity" class="quantity-input text-center w-100" value="1" min="1" readonly>
                            <button type="button" class=" quantity-btn" onclick="changeQuantity(1)">+</button>
                        </div>
                    </div>

                    <input type="submit" class="form-control btn btn-payment mt-3" value="{{ __('store.store_show.order_now_button') }}">
                </form>

                <div class="order-summary mt-4 p-4 bg-light rounded-3">
                    <h5 class="mb-3 fw-bold border-bottom pb-2"><i class="fas fa-receipt me-2"></i>{{ __('store.store_show.order_summary') }}</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span>{{ __('store.store_show.product_price') }}</span>
                        <span><span class="fw-bold" id="product-price">{{$product->price}}</span> دج</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>{{ __('store.store_show.quantity') }}</span>
                        <span class="fw-bold" id="summary-quantity">1</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>{{ __('store.store_show.delivery_price') }}</span>
                        <span class="fw-bold"><span id="delivery-price">0</span> دج</span>
                    </div>
                    <div class="d-flex justify-content-between mt-3 pt-2 border-top">
                        <span class="fw-bold">{{ __('store.store_show.total_price') }}</span>
                        <span class="fw-bold total-price-summary fs-5"><span id="total-price">{{$product->price}}</span> دج</span>
                    </div>
                </div>
            </div>

            <div class="product-shop-details mb-4">
                <h1 class="title-shop mb-3">{{ __('store.store_show.product_information') }}</h1>
                <div class="info-details d-flex justify-content-between">
                    <p>{{ __('store.store_show.price') }}</p>
                    <span class="p-price">{{$product->price}} دج</span>
                </div>
                <div class="info-details d-flex justify-content-between">
                    <p>{{ __('store.store_show.category') }}</p>
                    <p>{{$product->category->name}}</p>
                </div>
                <div class="info-details d-flex justify-content-between">
                    <p>{{ __('store.store_show.views_count') }}</p>
                    <p>{{$product->views}}</p>
                </div>
                <div class="info-details d-flex justify-content-between">
                    <p>{{ __('store.store_show.sales_count') }}</p>
                    <p>{{$product->sales_count}}</p>
                </div>
                <div class="info-details d-flex justify-content-between">
                    <p>{{ __('store.store_show.added_date') }}</p>
                    <p>{{\Carbon\Carbon::parse($product->created_at)->translatedFormat('d F Y', 'ar')}}</p>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    /**
     * This function handles the image change with a fade effect.
     * @param {HTMLElement} clickedImage - The thumbnail image element that was clicked.
     *
     * هذه الدالة تعالج تغيير الصورة مع تأثير التلاشي.
     * @param {HTMLElement} clickedImage - عنصر الصورة المصغرة الذي تم النقر عليه.
     */
    function changeImage(clickedImage) {
        // Get the main image element by its ID.
        // الحصول على عنصر الصورة الرئيسية بواسطة الـ ID.
        const mainImage = document.getElementById('mainImage');

        // 1. Add the 'fade-out' class to make the image transparent.
        // The CSS transition will handle the animation.
        // ١. أضف كلاس 'fade-out' لجعل الصورة شفافة. سينفذ الـ CSS التأثير الحركي.
        mainImage.classList.add('fade-out');

        // 2. Wait for the fade-out animation to finish before changing the source.
        // The timeout duration should match the CSS transition duration (400ms = 0.4s).
        // ٢. انتظر حتى ينتهي تأثير التلاشي للخارج قبل تغيير مصدر الصورة.
        // يجب أن تتطابق مدة المؤقت مع مدة الانتقال في CSS (400ms = 0.4s).
        setTimeout(() => {
            // 3. Change the source of the main image to the source of the clicked thumbnail.
            // ٣. قم بتغيير مصدر الصورة الرئيسية إلى مصدر الصورة المصغرة التي تم النقر عليها.
            mainImage.src = clickedImage.src;

            // 4. Remove the 'fade-out' class to make the image visible again.
            // The CSS transition will animate the opacity back to 1, creating a fade-in effect.
            // ٤. قم بإزالة كلاس 'fade-out' لجعل الصورة مرئية مرة أخرى.
            // سينفذ الـ CSS تأثير التلاشي للداخل.
            mainImage.classList.remove('fade-out');
        }, 400); // This time matches the transition duration in the CSS.
    }
</script>

<script>
    const shippings = @json($shippings);
    const product=@json($product);
    const productVariations = @json($productVariations);
    const municipalities = @json($municipalities); // تمرير كل البلديات من السيرفر
    const stateSelect = document.querySelector('select[name="state_id"]');
    const officePrice = document.getElementById('office-price');
    const homePrice = document.getElementById('home-price');
    const deliveryPrices = document.getElementById('delivery-prices');
    const deliveryInput = document.getElementById('delivery_type_input');
    const btnOffice = document.getElementById('btn-office');
    const btnHome = document.getElementById('btn-home');


    let ProductPrice=document.getElementById('product-price')
    let ProductQuantity=document.getElementById('summary-quantity')
    let DeliveryPrice=document.getElementById('delivery-price')
    let TotalPrice=document.getElementById('total-price')

    const deliveryPriceInput = document.getElementById('delivery_price_input');
    const totalPriceInput = document.getElementById('total_price_input');

    // عند تغيير الولاية
    stateSelect.addEventListener('change', function () {
        const selectedState = this.value;
        const shipping = shippings.find(s => s.id == selectedState);
        if (shipping) {
            if(product.free_shipping_office){
                officePrice.textContent = 0;
            }else{
                officePrice.textContent = shipping.to_office_price;
            }
            if(product.free_shipping_home){
                homePrice.textContent = 0;
            }else{
                homePrice.textContent = shipping.to_home_price;
            }
            deliveryPrices.style.display = 'block';
        } else {
            deliveryPrices.style.display = 'none';
        }
    });

    // عند اختيار "إلى المكتب"
    btnOffice.addEventListener('click', function () {
        deliveryInput.value = 'to_office';
        btnOffice.classList.remove('btn-outline-primary');
        btnOffice.classList.add('btn-primary');
        btnHome.classList.remove('btn-success');
        btnHome.classList.add('btn-outline-success');
        DeliveryPrice.textContent =officePrice.textContent
        const total = Number(officePrice.textContent) + Number(ProductPrice.textContent) * Number(ProductQuantity.textContent);
        TotalPrice.textContent = total;
        deliveryPriceInput.value = officePrice.textContent;
        totalPriceInput.value = total;

    });

    // عند اختيار "إلى المنزل"
    btnHome.addEventListener('click', function () {
        deliveryInput.value = 'to_home';
        btnHome.classList.remove('btn-outline-success');
        btnHome.classList.add('btn-success');
        btnOffice.classList.remove('btn-primary');
        btnOffice.classList.add('btn-outline-primary');
        DeliveryPrice.textContent =homePrice.textContent
        const total = Number(homePrice.textContent) + Number(ProductPrice.textContent) * Number(ProductQuantity.textContent);
        TotalPrice.textContent = total;
        deliveryPriceInput.value = homePrice.textContent; // ✅ صحيح
        totalPriceInput.value = total;



    });

    function changeQuantity(delta) {
        const input = document.getElementById('quantity');
        let current = parseInt(input.value);
        current += delta;
        if (current < 1) current = 1;
        input.value = current;
        ProductQuantity.textContent =current
        const total = Number(DeliveryPrice.textContent) + Number(ProductPrice.textContent) * Number(ProductQuantity.textContent);
        TotalPrice.textContent = total;
        totalPriceInput.value = total;
    }
    document.querySelectorAll('select[name^="attributes"]').forEach(select => {
    select.addEventListener('change', updatePriceFromVariation);
    });

 function updatePriceFromVariation() {
    const selectedValues = Array.from(document.querySelectorAll('select[name^="attributes"]'))
        .map(select => parseInt(select.value))
        .filter(Boolean); // نحذف الفراغات


    if (selectedValues.length === 0) return;

    let matched = productVariations.find(variation => {
        const variationValueIds = variation.attribute_values.map(val => val.id).sort();
        const selected = [...selectedValues].sort();
        return JSON.stringify(variationValueIds) === JSON.stringify(selected);
    });

    if (matched) {
        document.getElementById('product-price').textContent = matched.price;

     const total = matched.price * parseInt(ProductQuantity.textContent) + Number(DeliveryPrice.textContent);
    document.getElementById('total-price').textContent = total;

  // تحديث القيم المخفية
  totalPriceInput.value = total;
  document.getElementById('product_variation_id_input').value = matched.id;


    }


    }

 document.getElementById('state-select').addEventListener('change', function () {
        const stateId = this.value;
        const municipalitySelect = document.getElementById('municipality-select');

        // تصفية البلديات
        const filtered = municipalities.filter(m => m.state_id == stateId);

        // بناء الخيارات
        let options = '<option value="" selected disabled>{{ __('store.store_show.select_municipality') }}</option>';
        filtered.forEach(m => {
            const isDelivery = Boolean(Number(m.is_delivery)); // تحويل آمن للمنطق
            const currentLocale = '{{ App::getLocale() }}';
            const name = currentLocale === 'fr' ? m.name_fr : m.name;

            if (isDelivery) {

                options += `<option value="${m.id}">${name}</option>`;
            }else{
                options += `<option value="${m.id}">${name} {{ __('store.store_show.delivery_not_available') }}</option>`;
            }

        });


        municipalitySelect.innerHTML = options;
        municipalitySelect.disabled = false;
    });



</script>


@endsection

