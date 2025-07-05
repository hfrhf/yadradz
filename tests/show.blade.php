@extends('base')
@section('title','Product')


@section('content')
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
        <h4 class="title-product">{{$product->name}}</h4>
        <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" value="1">
            <button type="submit" class=" btn-add">اضف الى السلة</button>
        </form>

    </div>
    <div class="product-show">
        <div class="product-info">
            <div class="product-slider">
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
                <h1 class="description-product">الوصف</h1>
                <div>{!! $product->description !!}</div>
            </div>



        </div>
        <div class="product-shop">
            <div class="product-shop-buy">
                <h1 class="title-shop mb-3">شراء المنتج</h1>
                <form action="" method="post">
                    @csrf
                    <input type="hidden" id="product_price" value="{{ $product->price }}">
                    <div class="form-group">
                        <input type="text" placeholder="الاسم الكامل" name="fullname" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="tel" placeholder="رقم الهاتف " name="phone" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="email" placeholder=" البريد الالكتروني (اختياري) " name="email" class="form-control">
                    </div>

                    <div class="form-group">
                        @foreach ($attributes as $attribute)
                        <div class="form-group">
                            <select name="attributes[{{ $attribute->id }}]" class="form-control" required>
                                <option value="" disabled selected>اختر {{ $attribute->name }}</option>
                                @foreach ($attribute->values as $value)
                                    <option value="{{ $value->id }}">{{ $value->value }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endforeach
                    </div>

                    <div class="form-group">
                        <select class="form-control" name="state" id="">
                            <option value="" selected disabled>اختر الولاية</option>
                            @foreach ($shippings as $index => $shipping)
                            <option value="{{ $shipping->state }}">{{ $index + 1 }}-{{ $shipping->state }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="delivery-prices" class="form-group mt-3" style="display: none;">
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-primary" id="btn-office">
                                📦 التوصيل إلى <strong>المكتب:</strong> <span id="office-price"></span> دج
                            </button>
                            <button type="button" class="btn btn-outline-success" id="btn-home">
                                🏠 التوصيل إلى <strong>المنزل:</strong> <span id="home-price"></span> دج
                            </button>
                        </div>
                        <input type="hidden" name="delivery_type" id="delivery_type_input">
                    </div>

                    <div class="form-group">
                        <input type="text" placeholder=" البلدية " name="city" class="form-control">
                    </div>
                    <div class="form-group">

                        <div class="d-flex  align-items-center gap-2" style="max-width: 200px">
                            <button type="button" class="btn btn-outline-secondary" onclick="changeQuantity(-1)">-</button>
                            <input type="number" name="quantity" id="quantity" class="form-control text-center"
                                   value="1" min="1" style="width: 70px;" readonly>
                            <button type="button" class="btn btn-outline-secondary" onclick="changeQuantity(1)">+</button>
                        </div>
                    </div>






                    <input type="submit" class="form-control btn btn-success mt-3" value="اطلب الان">
                </form>
                <!-- ✅ ملخص الطلبية -->
<div id="order-summary" class="card mt-4 p-3 bg-light">
    <h5 class="mb-3">📦 ملخص الطلبية:</h5>
    <ul class="list-group mb-2">
        <li class="list-group-item d-flex justify-content-between">
            <span>سعر المنتج × الكمية:</span>
            <strong><span id="product_total">0</span> دج</strong>
        </li>
        <li class="list-group-item d-flex justify-content-between">
            <span>سعر التوصيل:</span>
            <strong><span id="shipping_price">0</span> دج</strong>
        </li>
        <li class="list-group-item d-flex justify-content-between bg-success text-white">
            <span>الإجمالي:</span>
            <strong><span id="total_price">0</span> دج</strong>
        </li>
    </ul>
</div>

            </div>

            <div class="product-shop-details mb-4">
                <h1 class="title-shop mb-3 ">معلومات المنتج</h1>
                <div class="info-details d-flex justify-content-between ">
                    <p>السعر:</p>
                    <span class="p-price">{{$product->price}}$</span>
                </div>
                <div class="info-details d-flex justify-content-between ">
                    <p> التصنيف:</p>
                    <p>{{$product->category->name}}</p>
                </div>
                <div class="info-details d-flex justify-content-between ">
                    <p> عدد المشاهدات :</p>
                    <p>{{$product->views}}</p>
                </div>
                <div class="info-details d-flex justify-content-between ">
                    <p> عدد المبيعات :</p>
                    <p>{{$product->sales_count}}</p>
                </div>
                <div class="info-details d-flex justify-content-between ">
                    <p>  تاريخ الاضافة  :</p>
                    <p>{{\Carbon\Carbon::parse($product->created_at)->translatedFormat('d F Y', 'ar')}}  </p>
                </div>


            </div>

        </div>
    </div>

</div>

<script>
    function changeImage(element) {
    const mainImage = document.getElementById('mainImage');
    const images = document.querySelectorAll('.images-dawn-slider img');

    // تحديث الصورة الكبرى
    mainImage.src = element.src;

    // إزالة النمط النشط من جميع الصور المصغرة
    images.forEach(img => img.classList.remove('active'));

    // إضافة النمط النشط للصورة التي تم النقر عليها
    element.classList.add('active');
}
</script>
<script>
    let productPrice = parseFloat(document.getElementById('product_price').value);
    let quantityInput = document.getElementById('quantity');
    let deliveryTypeInput = document.getElementById('delivery_type_input');

    let officePriceEl = document.getElementById('office-price');
    let homePriceEl = document.getElementById('home-price');

    function updateSummary() {
        let quantity = parseInt(quantityInput.value);
        let shippingPrice = 0;

        if (deliveryTypeInput.value === 'office') {
            shippingPrice = parseInt(officePriceEl.innerText) || 0;
        } else if (deliveryTypeInput.value === 'home') {
            shippingPrice = parseInt(homePriceEl.innerText) || 0;
        }

        let productTotal = productPrice * quantity;
        let total = productTotal + shippingPrice;

        document.getElementById('product_total').innerText = productTotal.toLocaleString();
        document.getElementById('shipping_price').innerText = shippingPrice.toLocaleString();
        document.getElementById('total_price').innerText = total.toLocaleString();
    }

    // استمع لتغيير الكمية أو نوع التوصيل
    quantityInput.addEventListener('change', updateSummary);
    document.getElementById('btn-office').addEventListener('click', function () {
        deliveryTypeInput.value = 'office';
        updateSummary();
    });
    document.getElementById('btn-home').addEventListener('click', function () {
        deliveryTypeInput.value = 'home';
        updateSummary();
    });
    function changeQuantity(delta) {
        const input = document.getElementById('quantity');
        let current = parseInt(input.value);
        current += delta;
        if (current < 1) current = 1;
        input.value = current;
        updateSummary();
    }
    const shippings = @json($shippings);
    const stateSelect = document.querySelector('select[name="state"]');
    const officePrice = document.getElementById('office-price');
    const homePrice = document.getElementById('home-price');
    const deliveryPrices = document.getElementById('delivery-prices');
    const deliveryInput = document.getElementById('delivery_type_input');
    const btnOffice = document.getElementById('btn-office');
    const btnHome = document.getElementById('btn-home');

    // عند تغيير الولاية
    stateSelect.addEventListener('change', function () {
        const selectedState = this.value;
        const shipping = shippings.find(s => s.state === selectedState);
        if (shipping) {
            officePrice.textContent = shipping.to_office_price;
            homePrice.textContent = shipping.to_home_price;
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
    });

    // عند اختيار "إلى المنزل"
    btnHome.addEventListener('click', function () {
        deliveryInput.value = 'to_home';
        btnHome.classList.remove('btn-outline-success');
        btnHome.classList.add('btn-success');

        btnOffice.classList.remove('btn-primary');
        btnOffice.classList.add('btn-outline-primary');
    });

    // حدث المجموع عند أول تحميل
    updateSummary();
</script>






@endsection

