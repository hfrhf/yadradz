@section('sidebar')
<style>
    /* Modern Sidebar Styles */
    .dddd {
        text-align: right;
    }






</style>

@php
$defClass = 'sidebar-link';
$isProducts = Route::is('product.*');
$isCategory = Route::is('category.*');
$isProfile = Route::is('profile.*');
$isOrder = Route::is('order.*');
$isSettings = Route::is('settings.*');
$isColors = Route::is('colors.*');
$isAdminInfo = Route::is('admin-info.*');
$isDashboard = Route::is(Auth::user()->getRedirectRoute());
$isReports = Route::is('reports.*');
$isRoles = Route::is('roles.*');
$isPermissions = Route::is('permissions.*');
$isAttribute = Route::is('attributes.*');
$isAttributeValues = Route::is('attribute-values.*');
$isProductVariations = Route::is('product-variations.*');
$isBlackList = Route::is('blacklist.*');
$isCustomerOrders = Route::is('customer-orders.*');
$isSheets = Route::is('google-sheets.*');
$isShipping = Route::is('shippings.*');
$isConfirmer = Route::is('confirmers.*');
$isShippingCompany = Route::is('shippingcompany.*');
$isNotificationCreate=Route::is('notifications.*');
// Marketing routes
$isFacebook = Route::is('facebook.*');
$isTiktok = Route::is('tiktok.*');
$isGa = Route::is('ga.*');
$isGtm = Route::is('gtm.*');

// Check if any child is active for each collapse section
$hasActiveUserManagement = $isProfile || $isRoles || $isPermissions;
$hasActiveProductManagement = $isProducts || $isCategory || $isAttribute || $isAttributeValues || $isProductVariations;
$hasActiveOrdersManagement = $isCustomerOrders || $isSheets || $isBlackList;
$hasActiveMarketing = $isFacebook || $isTiktok || $isGa || $isGtm;
$hasActiveSettings = $isSettings || $isAdminInfo || $isColors;
$hasActiveShippingManagement = $isShippingCompany || $isShipping;
@endphp

<div class="sidebar">
    <!-- Title Section -->
    <div class="title-sidebar glass-effect">
        <a href="/">
            <h1 class="title-dash">{{ $setting->site_name }}</h1>
        </a>
    </div>

    <!-- Dashboard Link -->
    <a class="{{ $defClass }} {{ $isDashboard ? 'active-sidebar' : '' }}"
       href="{{ route(Auth::user()->getRedirectRoute()) }}">
        <i class="fa-solid fa-house"></i>
        <span>الرئيسية</span>
    </a>

    <!-- User Management Section -->
    <div>
        <button class="collapse-btn {{ $hasActiveUserManagement ? 'has-active-child' : '' }}" data-target="collapse-access-control">
            <i class="fa-solid fa-users-cog"></i>
            <span>إدارة المستخدمين</span>
        </button>
        <div class="collapse-content {{ $hasActiveUserManagement ? 'show' : '' }}" id="collapse-access-control">
            @canany(['profile_access', 'roles_access', 'permissions_access','notification_create'])
            <ul>
                @can('profile_access')
                <li>
                    <a class="{{ $defClass }} {{ $isProfile ? 'active-sidebar' : '' }}"
                       href="{{ route('profile.index') }}">
                        <i class="fa-solid fa-users"></i>
                        <span>المستخدمين</span>
                    </a>
                </li>
                @endcan

                @can('roles_access')
                <li>
                    <a class="{{ $defClass }} {{ $isRoles ? 'active-sidebar' : '' }}"
                       href="{{ route('roles.index') }}">
                        <i class="fa-solid fa-user-shield"></i>
                        <span>الأدوار</span>
                    </a>
                </li>
                @endcan

                @can('permissions_access')
                <li>
                    <a class="{{ $defClass }} {{ $isPermissions ? 'active-sidebar' : '' }}"
                       href="{{ route('permissions.index') }}">
                        <i class="fa-solid fa-key"></i>
                        <span>الصلاحيات</span>
                    </a>
                </li>
                @endcan
                @can('permissions_access')
                <li>
                    <a class="{{ $defClass }} {{ $isConfirmer ? 'active-sidebar' : '' }}"
                       href="{{ route('confirmers.index') }}">
                        <i class="fa-solid fa-key"></i>
                        <span>المؤكدين</span>
                    </a>
                </li>
                @endcan
                @can('notification_create')
                <li>
                    <a class="{{ $defClass }} {{ $isNotificationCreate ? 'active-sidebar' : '' }}"
                       href="{{ route('notifications.create') }}">
                        <i class="fa-solid fa-users"></i>
                        <span>الاشعارات</span>
                    </a>
                </li>
                @endcan
            </ul>
            @endcanany
        </div>
    </div>

    <!-- Product Management Section -->
    <div>
        <button class="collapse-btn {{ $hasActiveProductManagement ? 'has-active-child' : '' }}" data-target="collapse1">
            <i class="fa-solid fa-boxes-stacked"></i>
            <span>ادارة المنتجات</span>
        </button>
        <div class="collapse-content {{ $hasActiveProductManagement ? 'show' : '' }}" id="collapse1">
            @canany(['product_access', 'attribute_access', 'attribute_values_access', 'product_variations_access'])
            <ul>
                @can('category_access')
                <li>
                    <a class="{{ $defClass }} {{ $isCategory ? 'active-sidebar' : '' }}"
                       href="{{ route('category.index') }}">
                        <i class="fa-solid fa-list"></i>
                        <span>الاقسام</span>
                    </a>
                </li>
                @endcan

                @can('product_access')
                <li>
                    <a class="{{ $defClass }} {{ $isProducts ? 'active-sidebar' : '' }}"
                       href="{{ route('product.index') }}">
                        <i class="fa-solid fa-box"></i>
                        <span>المنتجات</span>
                    </a>
                </li>
                @endcan

                @can('attribute_access')
                <li>
                    <a class="{{ $defClass }} {{ $isAttribute ? 'active-sidebar' : '' }}"
                       href="{{ route('attributes.index') }}">
                        <i class="fa-solid fa-tags"></i>
                        <span>خصائص المنتجات</span>
                    </a>
                </li>
                @endcan

                @can('attribute_values_access')
                <li>
                    <a class="{{ $defClass }} {{ $isAttributeValues ? 'active-sidebar' : '' }}"
                       href="{{ route('attribute-values.index') }}">
                        <i class="fa-solid fa-tag"></i>
                        <span>قيم الخصائص</span>
                    </a>
                </li>
                @endcan

                @can('product_variations_access')
                <li>
                    <a class="{{ $defClass }} {{ $isProductVariations ? 'active-sidebar' : '' }}"
                       href="{{ route('product-variations.index') }}">
                        <i class="fa-solid fa-cubes"></i>
                        <span>التوليفات</span>
                    </a>
                </li>
                @endcan
            </ul>
            @endcanany
        </div>
    </div>

    <!-- Orders Management Section -->
    <div>
        <button class="collapse-btn {{ $hasActiveOrdersManagement ? 'has-active-child' : '' }}" data-target="collapse-operations">
            <i class="fa-solid fa-dolly"></i>
            <span>إدارة الطلبيات</span>
        </button>
        <div class="collapse-content {{ $hasActiveOrdersManagement ? 'show' : '' }}" id="collapse-operations">
            @canany(['customer_orders_access', 'sheets_access', 'blacklist_access'])
            <ul>
                @can('customer_orders_access')
                <li>
                    <a class="{{ $defClass }} {{ $isCustomerOrders ? 'active-sidebar' : '' }}"
                       href="{{ route('customer-orders.index') }}">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span>الطلبيات</span>
                    </a>
                </li>
                @endcan

                @can('sheets_access')
                <li>
                    <a class="{{ $defClass }} {{ $isSheets ? 'active-sidebar' : '' }}"
                       href="{{ route('google-sheets.index') }}">
                        <i class="fa-brands fa-google-drive"></i>
                        <span>Google Sheets</span>
                    </a>
                </li>
                @endcan

                @can('blacklist_access')
                <li>
                    <a class="{{ $defClass }} {{ $isBlackList ? 'active-sidebar' : '' }}"
                       href="{{ route('blacklist.index') }}">
                        <i class="fa-solid fa-ban"></i>
                        <span>قائمة الحظر</span>
                    </a>
                </li>
                @endcan
            </ul>
            @endcanany
        </div>
    </div>

    <!-- Marketing Section -->
    <div>
        <button class="collapse-btn {{ $hasActiveMarketing ? 'has-active-child' : '' }}" data-target="collapse3">
            <i class="fa-solid fa-bullhorn"></i>
            <span>ادارة التسويق</span>
        </button>
        <div class="collapse-content {{ $hasActiveMarketing ? 'show' : '' }}" id="collapse3">
            @canany(['facebook_access', 'tiktok_access', 'ga_access', 'gtm_access'])
            <ul>
                @can('facebook_access')
                <li>
                    <a class="{{ $defClass }} {{ $isFacebook ? 'active-sidebar' : '' }}"
                       href="{{ route('facebook.index') }}">
                        <i class="fa-brands fa-facebook-f"></i>
                        <span>فيسبوك بيكسل</span>
                    </a>
                </li>
                @endcan

                @can('tiktok_access')
                <li>
                    <a class="{{ $defClass }} {{ $isTiktok ? 'active-sidebar' : '' }}"
                       href="{{ route('tiktok.index') }}">
                        <i class="fa-brands fa-tiktok"></i>
                        <span>تيك توك بيكسل</span>
                    </a>
                </li>
                @endcan

                @can('ga_access')
                <li>
                    <a class="{{ $defClass }} {{ $isGa ? 'active-sidebar' : '' }}"
                       href="{{ route('ga.index') }}">
                        <i class="fa-brands fa-google"></i>
                        <span>Google Analytics</span>
                    </a>
                </li>
                @endcan

                @can('gtm_access')
                <li>
                    <a class="{{ $defClass }} {{ $isGtm ? 'active-sidebar' : '' }}"
                       href="{{ route('gtm.index') }}">
                        <i class="fa-solid fa-tags"></i>
                        <span>Google Tag Manager</span>
                    </a>
                </li>
                @endcan
            </ul>
            @endcanany
        </div>
    </div>


    <!-- General Settings Section -->
    <div>
        <button class="collapse-btn {{ $hasActiveSettings ? 'has-active-child' : '' }}" data-target="collapse2">
            <i class="fa-solid fa-cogs"></i>
            <span>الاعدادات العامة</span>
        </button>
        <div class="collapse-content {{ $hasActiveSettings ? 'show' : '' }}" id="collapse2">
            @canany(['setting_access', 'admin_info_access', 'colors_access'])
            <ul>
                @can('setting_access')
                <li>
                    <a class="{{ $defClass }} {{ $isSettings ? 'active-sidebar' : '' }}"
                       href="{{ route('settings.index') }}">
                        <i class="fa-solid fa-gears"></i>
                        <span>الاعدادات</span>
                    </a>
                </li>
                @endcan

                @can('admin_info_access')
                <li>
                    <a class="{{ $defClass }} {{ $isAdminInfo ? 'active-sidebar' : '' }}"
                       href="{{ route('info.index') }}">
                        <i class="fa-regular fa-address-card"></i>
                        <span>بياناتك</span>
                    </a>
                </li>
                @endcan

                @can('colors_access')
                <li>
                    <a class="{{ $defClass }} {{ $isColors ? 'active-sidebar' : '' }}"
                       href="{{ route('colors.index') }}">
                        <i class="fa-solid fa-palette"></i>
                        <span>الالوان</span>
                    </a>
                </li>
                @endcan
            </ul>
            @endcanany
        </div>
    </div>

    <!-- Direct Links -->
    <div>
        <button class="collapse-btn {{ $hasActiveShippingManagement ? 'has-active-child' : '' }}" data-target="collapse4">
            <i class="fa-solid fa-truck-fast"></i>
            <span> ادارة التوصيل</span>
        </button>
        <div class="collapse-content {{ $hasActiveShippingManagement ? 'show' : '' }}" id="collapse4">
            @canany(['shippings_access', 'shippings_access'])
            <ul>
                @can('shippings_access')
                <li>
                    <a class="{{ $defClass }} {{ $isShippingCompany ? 'active-sidebar' : '' }}"
                       href="{{ route('shippingcompany.index') }}">
                        <i class="fa-solid fa-sitemap"></i>
                        <span> شركات التوصيل</span>
                    </a>
                </li>
                @endcan
                @can('shippings_access')
                <li>
                    <a class="{{ $defClass }} {{ $isShipping ? 'active-sidebar' : '' }}"
                   href="{{ route('shippings.index') }}">
                    <i class="fa-solid fa-truck"></i>
                    <span>التوصيل</span>
                </a>
                </li>
                @endcan

            </ul>

            @endcanany

        </div>


    </div>




    @can('report_access')
    <a class="{{ $defClass }} {{ $isReports ? 'active-sidebar' : '' }}"
       href="{{ route('reports.index') }}">
        <i class="fa-solid fa-chart-line"></i>
        <span>التقارير</span>
    </a>
    @endcan
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Collapse functionality
        const collapseBtns = document.querySelectorAll('.collapse-btn');
        collapseBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const toggleId = btn.getAttribute('data-target');
                const toggle = document.getElementById(toggleId);

                // Don't close sections that have active children unless explicitly clicked
                if (!btn.classList.contains('has-active-child')) {
                    // Close other open collapses
                    document.querySelectorAll('.collapse-content.show').forEach(openCollapse => {
                        if (openCollapse.id !== toggleId) {
                            const otherBtn = document.querySelector(`.collapse-btn[data-target="${openCollapse.id}"]`);
                            if (!otherBtn.classList.contains('has-active-child')) {
                                openCollapse.classList.remove('show');
                                otherBtn.classList.remove('active');
                            }
                        }
                    });
                }

                // Toggle current collapse
                toggle.classList.toggle('show');
                btn.classList.toggle('active');
            });
        });

        // Sidebar toggle functionality
        const toggleBtn = document.getElementById('sidebar-toggle');
        const sidebarContainer = document.querySelector('.content-sidebar');

        if (localStorage.getItem('sidebar') === 'hidden') {
            sidebarContainer?.classList.add('collapsed');
        }

        if (toggleBtn && sidebarContainer) {
            toggleBtn.addEventListener('click', () => {
                sidebarContainer.classList.toggle('collapsed');
                localStorage.setItem('sidebar',
                    sidebarContainer.classList.contains('collapsed') ? 'hidden' : 'shown'
                );
            });
        }

        // Add smooth scroll behavior
        document.querySelectorAll('.sidebar-link').forEach(link => {
            link.addEventListener('click', function(e) {
                // Add ripple effect
                const ripple = document.createElement('span');
                ripple.style.position = 'absolute';
                ripple.style.borderRadius = '50%';
                ripple.style.background = 'rgba(255, 255, 255, 0.6)';
                ripple.style.transform = 'scale(0)';
                ripple.style.animation = 'ripple 0.6s linear';
                ripple.style.left = '50%';
                ripple.style.top = '50%';
                ripple.style.width = '20px';
                ripple.style.height = '20px';
                ripple.style.marginLeft = '-10px';
                ripple.style.marginTop = '-10px';

                this.appendChild(ripple);

                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });
    });

    // Add ripple animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
</script>
@endsection
