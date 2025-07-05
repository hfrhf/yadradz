{{-- ملاحظة مهمة: تأكد من وجود هذا السطر في <head> في ملف الـ layout الرئيسي لتطبيقك --}}
{{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}

<style>
    /* تصميم خاص بنظام الإشعارات */
    .notification-wrapper .notification-btn .notification-badge {
        position: absolute;
        top: 8px;
        right: 8px;
        width: 18px;
        height: 18px;
        background-color: #dc3545;
        color: white;
        border-radius: 50%;
        font-size: 10px;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #fff;
        transition: transform 0.2s ease;
    }

    .notification-wrapper .notification-btn .notification-badge:empty {
        display: none;
    }

    .notifications-dropdown {
        position: absolute;
        top: 120%;
        left: 0;
        width: 350px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 5px 25px rgba(0,0,0,0.15);
        opacity: 0;
        visibility: hidden;
        transform: translateY(10px);
        transition: all 0.3s ease;
        z-index: 1000;
    }

    .notifications-dropdown.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .notifications-dropdown-header {
        padding: 12px 16px;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .notifications-dropdown-header h6 {
        margin: 0;
        font-weight: 600;
    }

    .notifications-list {
        list-style: none;
        padding: 0;
        margin: 0;
        max-height: 350px;
        overflow-y: auto;
    }

    .notifications-list li {
        border-bottom: 1px solid #f0f0f0;
    }
    .notifications-list li:last-child {
        border-bottom: none;
    }

    .notification-item {
        display: flex;
        align-items: center;
        padding: 12px 16px;
        text-decoration: none;
        color: #333;
        transition: background-color 0.2s ease;
    }
    .notification-item:hover {
        background-color: #f8f9fa;
    }

    .notification-item.unread .notification-content p {
        font-weight: 600;
        color: #212529;
    }

    .notification-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: 12px; /* RTL margin */
        flex-shrink: 0;
    }

    .notification-icon.icon-info { background-color: #eef5ff; color: #3686ef; }
    .notification-icon.icon-warning { background-color: #fff8e6; color: #ffab00; }

    .notification-content {
        flex-grow: 1;
    }
    .notification-content p {
        margin: 0;
        font-size: 14px;
        line-height: 1.4;
    }
    .notification-content .time {
        font-size: 12px;
        color: #6c757d;
        margin-top: 4px;
    }
    .no-notifications {
        text-align: center;
        padding: 40px 20px;
        color: #6c757d;
    }
</style>

<header class="topbar">
    <div class="container-fluid topbar-container d-flex align-items-center justify-content-between px-3 px-lg-4">
        <!-- Left Side -->
        <div class="topbar-left d-flex align-items-center gap-3">
            <button class="menu-toggle d-flex align-items-center justify-content-center" id="sidebar-toggle" title="تبديل القائمة (Alt+M)">
                <i class="fa-solid fa-bars"></i>
            </button>
            <div class="page-title-wrapper">
                <h1 class="page-title m-0">لوحة التحكم</h1>
                <p class="breadcrumb"> لوحة التحكم / @yield('title') </p>
            </div>
        </div>

        <!-- Right Side -->
        <div class="topbar-right d-flex align-items-center gap-2">
            <button class="topbar-action d-flex align-items-center justify-content-center search-btn" title="بحث (Alt+S)">
                <i class="fa-solid fa-search"></i>
            </button>

            <!-- ================== بداية قسم الإشعارات ================== -->
            <div class="notification-wrapper position-relative">
                <button class="topbar-action d-flex align-items-center justify-content-center notification-btn" id="notification-bell" title="الإشعارات">
                    <i class="fa-regular fa-bell"></i>
                    <span class="notification-badge" id="notification-badge-count"></span>
                </button>

                <div class="notifications-dropdown" id="notifications-dropdown-menu">
                    <div class="notifications-dropdown-header">
                        <h6>الإشعارات</h6>
                    </div>
                    <ul class="notifications-list" id="notifications-list-container">
                        <!-- سيتم ملء الإشعارات هنا عبر JavaScript -->
                    </ul>
                </div>
            </div>
            <!-- ================== نهاية قسم الإشعارات ================== -->

            <div class="notification-wrapper position-relative">
                <a href="{{route('settings.index')}}" class="topbar-action d-flex align-items-center justify-content-center" title="الإعدادات">
                    <i class="fa-solid fa-cog"></i>
                </a>
            </div>

            <div class="vr mx-2 d-none d-lg-block"></div>

            <div class="profile-section d-flex align-items-center gap-3" title="ملف المستخدم">
                <div class="profile-info text-end">
                    <div class="user-name"> {{Auth::user()->name}}</div>
                    <div class="user-role">مدير النظام</div>
                </div>
                <div class="profile-avatar position-relative">
                    <img class="avatar-img" src="{{asset('storage/'.($setting->logo ?? ''))}}" alt="صورة المستخدم">
                    <div class="status-indicator"></div>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // الكود الخاص بتبديل القائمة الجانبية
    const sidebarToggle = document.getElementById('sidebar-toggle');
    if (sidebarToggle) {
        let isCollapsed = false;
        sidebarToggle.addEventListener('click', () => {
            isCollapsed = !isCollapsed;
            const icon = sidebarToggle.querySelector('i');
            icon.style.transform = isCollapsed ? 'rotate(90deg)' : 'rotate(0deg)';
        });
    }

    // ================== بداية كود الإشعارات ==================
    const bellBtn = document.getElementById('notification-bell');
    const dropdownMenu = document.getElementById('notifications-dropdown-menu');
    const badge = document.getElementById('notification-badge-count');
    const notificationsList = document.getElementById('notifications-list-container');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // دالة لجلب الإشعارات من الخادم
    async function fetchNotifications() {
        try {
            const response = await fetch('/api/user/notifications', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                }
            });
            if (!response.ok) throw new Error('Network response was not ok.');
            const data = await response.json();
            updateUI(data);
        } catch (error) {
            console.error('فشل في جلب الإشعارات:', error);
            notificationsList.innerHTML = '<li class="no-notifications">فشل في تحميل الإشعارات.</li>';
        }
    }

    // دالة لتحديث واجهة المستخدم
    function updateUI(data) {
        // تحديث العداد
        if (data.unread && data.unread.length > 0) {
            badge.textContent = data.unread.length;
            badge.style.display = 'flex';
        } else {
            badge.style.display = 'none';
        }

        // مسح القائمة الحالية
        notificationsList.innerHTML = '';

        const allNotifications = [...data.unread, ...data.read];

        if (allNotifications.length === 0) {
            notificationsList.innerHTML = '<li class="no-notifications">لا توجد إشعارات جديدة.</li>';
            return;
        }

        // إضافة الإشعارات الجديدة إلى القائمة
        allNotifications.forEach(notification => {
            const isUnread = data.unread.some(unread => unread.id === notification.id);
            const li = document.createElement('li');
            li.innerHTML = `
                <a href="${notification.data.url || '#'}" class="notification-item ${isUnread ? 'unread' : ''}">
                    <div class="notification-icon icon-info">
                        <i class="fa-solid fa-bell"></i>
                    </div>
                    <div class="notification-content">
                        <p>${notification.data.message || notification.data.title}</p>
                        <span class="time">${formatTimeAgo(notification.created_at)}</span>
                    </div>
                </a>
            `;
            notificationsList.appendChild(li);
        });
    }

    // دالة لجعل الإشعارات مقروءة
    async function markAsRead() {
        // فقط أرسل الطلب إذا كان هناك إشعارات غير مقروءة
        if (badge.textContent === '' || parseInt(badge.textContent) === 0) {
            return;
        }

        try {
            await fetch('/api/user/notifications/mark-as-read', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken
                }
            });
            // تحديث العداد فوراً
            badge.textContent = '';
            badge.style.display = 'none';
        } catch (error) {
            console.error('فشل في تحديث حالة الإشعارات:', error);
        }
    }

    // دالة لتنسيق الوقت
    function formatTimeAgo(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const seconds = Math.floor((now - date) / 1000);
        let interval = seconds / 31536000;
        if (interval > 1) return `منذ ${Math.floor(interval)} سنة`;
        interval = seconds / 2592000;
        if (interval > 1) return `منذ ${Math.floor(interval)} شهر`;
        interval = seconds / 86400;
        if (interval > 1) return `منذ ${Math.floor(interval)} يوم`;
        interval = seconds / 3600;
        if (interval > 1) return `منذ ${Math.floor(interval)} ساعة`;
        interval = seconds / 60;
        if (interval > 1) return `منذ ${Math.floor(interval)} دقيقة`;
        return `منذ ${Math.floor(seconds)} ثانية`;
    }


    // إضافة مستمع حدث النقر على أيقونة الجرس
    bellBtn.addEventListener('click', (e) => {
        e.stopPropagation(); // منع إغلاق القائمة فوراً
        dropdownMenu.classList.toggle('show');
        if (dropdownMenu.classList.contains('show')) {
            markAsRead();
        }
    });

    // إغلاق القائمة عند النقر في أي مكان آخر
    document.addEventListener('click', () => {
        if (dropdownMenu.classList.contains('show')) {
            dropdownMenu.classList.remove('show');
        }
    });

    // منع إغلاق القائمة عند النقر داخلها
    dropdownMenu.addEventListener('click', (e) => {
        e.stopPropagation();
    });

    // جلب الإشعارات عند تحميل الصفحة
    fetchNotifications();

    // جلب الإشعارات كل دقيقة
    setInterval(fetchNotifications, 60000);
    // ================== نهاية كود الإشعارات ==================
});
</script>