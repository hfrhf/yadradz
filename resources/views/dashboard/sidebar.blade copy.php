@section('sidebar')
<style>

    li{
        list-style: none;
    }

    .collapse-btn{
        border: none;
        background: none;
        color: var(--text-color);
        transition: 0.3s ease;
        font-style: normal;
        font-weight: 700;
        line-height: normal;
        margin-bottom: 25px;

    }

    .collapse-content{
        transform: scaleY(0);
        transform-origin: top;
        height: 0;
        transition: all 0.3s ease;
    }

    .collapse-content.show{
        height: 100%;
        transform: scaleY(1);
        transition: all 0.3s ease;

    }
    .collapse-btn.active{
        margin-bottom: 0px;
    }


</style>
@php
   $isProducts = Route::is('product.*');
   $isCategory = Route::is('category.*');
   $isProfile = Route::is('profile.*');
   $isOrder = Route::is('order.*');
   $isSettings = Route::is('settings.*');
   $isColors = Route::is('colors.*');
   $isAdminInfo = Route::is('admin-info.*');
   $isSales = Route::is('sales.*');
   $isDashboard = Route::is(Auth::user()->getRedirectRoute());
   $isReports = Route::is('reports.*');
   $isRoles = Route::is('roles.*');
   $isPermissions = Route::is('permissions.*');
   $isAttribute=Route::is('attributes.*');
   $isAttributeValues=Route::is('attribute-values.*');
   $isProductVariations=Route::is('product-variations.*');
   $isShipping=Route::is('shippings.*');
   $isCustomerOrders=Route::is('customer-orders.*');
   $defClass = 'sidebar-link';
@endphp

<div class="sidebar">

    <div class="title-sidebar">
        <a href="/"> <span class="title-dash">{{$setting->site_name}}</span></a>
    </div>


    <a @class([$defClass, 'active-sidebar'=>$isDashboard]) href={{route(Auth::user()->getRedirectRoute())}}>
        <i class="fa-solid fa-house"></i> <span>الرئيسية</span>
    </a>
    <button class="collapse-btn " data-target="collapse1">ادارة المنتجات</button>
    <div class="collapse-content" id="collapse1">
        @canany(['product_access', 'attribute_access', 'attribute_values_access','product_variations_access'])
        <ul>
            <li>
                @can('product_access')
        <a @class([$defClass, 'active-sidebar'=>$isProducts]) href={{route('product.index')}}>
            <i class="fa-solid fa-box"></i> <span>المنتجات</span>
        </a>
        @endcan
            </li>
            <li>
                @can('attribute_access')
                <a @class([$defClass, 'active-sidebar'=>$isAttribute]) href={{route('attributes.index')}}>
                    <i class="fa-solid fa-box"></i> <span>خصائص المنتجات</span>
                </a>
                @endcan
            </li>
            <li>
                @can('attribute_values_access')
        <a @class([$defClass, 'active-sidebar'=>$isAttributeValues]) href={{route('attribute-values.index')}}>
            <i class="fa-solid fa-box"></i> <span>قيم الخصائص</span>
        </a>
        @endcan

            </li>
            <li>
                @can('product_variations_access')
                <a @class([$defClass, 'active-sidebar'=>$isProductVariations]) href={{route('product-variations.index')}}>
                    <i class="fa-solid fa-box"></i> <span> التوليفات</span>
                </a>
                @endcan

            </li>




        </ul>
        @endcanany

    </div>





    @can('shippings_access')
    <a @class([$defClass, 'active-sidebar'=>$isShipping]) href={{route('shippings.index')}}>
        <i class="fa-solid fa-box"></i> <span>التوصيل</span>
    </a>
    @endcan
    @can('customer_orders_access')
    <a @class([$defClass, 'active-sidebar'=>$isCustomerOrders]) href={{route('customer-orders.index')}}>
        <i class="fa-solid fa-box"></i> <span>الطلبيات</span>
    </a>
    @endcan



    @can('category_access')
    <a @class([$defClass, 'active-sidebar'=>$isCategory]) href={{route('category.index')}}>
        <i class="fa-solid fa-list"></i> <span>الاقسام</span>
    </a>
    @endcan

    @can('profile_access')
    <a @class([$defClass, 'active-sidebar'=>$isProfile]) href={{route('profile.index')}}>
        <i class="fa-solid fa-users"></i> <span>المستخدمين</span>
    </a>
    @endcan

    @can('sales_access')
    <a @class([$defClass, 'active-sidebar'=>$isSales]) href={{route('sales.index')}}>
        <i class="fa-solid fa-sack-dollar"></i> <span>المبيعات</span>
    </a>
    @endcan



    @can('report_access')
    <a @class([$defClass, 'active-sidebar'=>$isReports]) href={{route('reports.index')}}>
        <i class="fa-solid fa-chart-line"></i> <span>التقارير</span>
    </a>
    @endcan
    @can('roles_access')
    <a @class([$defClass, 'active-sidebar'=>$isRoles]) href={{route('roles.index')}}>
        <i class="fa-solid fa-chart-line"></i> <span>الادوار</span>
    </a>
    @endcan
    @can('permissions_access')
    <a @class([$defClass, 'active-sidebar'=>$isPermissions]) href={{route('permissions.index')}}>
        <i class="fa-solid fa-chart-line"></i> <span>الصلاحيات</span>
    </a>
    @endcan

    @can('setting_access')
    <a @class([$defClass, 'active-sidebar'=>$isSettings]) href={{route('settings.index')}}>
        <i class="fa-solid fa-gears"></i> <span>الاعدادات</span>
    </a>
    @endcan

    @can('admin_info_access')
    <a @class([$defClass, 'active-sidebar'=>$isAdminInfo]) href={{route('info.index')}}>
        <i class="fa-regular fa-address-card"></i> <span>بياناتك</span>
    </a>
    @endcan

    @can('colors_access')
    <a @class([$defClass, 'active-sidebar'=>$isColors]) href={{route('colors.index')}}>
        <i class="fa-solid fa-palette"></i> <span>الالوان</span>
    </a>
    @endcan
</div>


<script>
    const collapseBtns = document.querySelectorAll('.collapse-btn');
    collapseBtns.forEach(btn=>{
        btn.addEventListener('click',()=>{
            console.log("Collapse clicked!");
            const toggleId=btn.getAttribute('data-target')
            const toggle=document.getElementById(toggleId);

           toggle.classList.toggle('show');
           btn.classList.toggle('active');

        })
    })

</script>
@endsection
