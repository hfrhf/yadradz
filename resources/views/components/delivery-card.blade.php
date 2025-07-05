<div class="position-relative" style="max-width: 400px;">
    <div class="delivery-icon-wrapper position-relative">
        <!-- البطاقة الرئيسية -->
        <div class="delivery-card position-relative d-flex justify-content-between align-items-center text-white p-3 gap-3 rounded-4 shadow-lg">
            <!-- الأنماط الزخرفية -->
            <div class="bg-pattern rounded-4"></div>
            <div class="decorative-dot" style="width: 10px; height: 10px; top: 6px; left: 10px;"></div>
            <div class="decorative-dot" style="width: 6px; height: 6px; bottom: 6px; right: 10px;"></div>

            <!-- المحتوى -->
            <div class="d-flex justify-content-between align-items-center gap-3 w-100" style="z-index: 1;">
                <!-- قسم النص -->
                <div class="text-section">
                    <h3 class="fw-bold fs-6 m-0">{{ $title }}</h3>
                    <p class="m-0" style="font-size: 0.8rem; opacity: 0.9;">خدمة سريعة ومضمونة</p>
                </div>

                <!-- قسم الأيقونات -->
                <div class="d-flex align-items-center gap-2">
                    <!-- أيقونة الشاحنة -->
                    <div class="position-relative d-flex align-items-center">
                        <div class="truck-glow"></div>
                        <div class="position-relative bg-white text-success rounded-circle shadow d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                            <i class="fa-solid fa-truck-fast fa-lg"></i>
                        </div>
                        <!-- خطوط السرعة -->
                        <div class="position-absolute d-flex flex-column gap-1" style="left: -18px;">
                            <div class="speed-line" style="width: 10px; background: rgba(255,255,255,0.6);"></div>
                            <div class="speed-line" style="width: 6px; background: rgba(255,255,255,0.4);"></div>
                            <div class="speed-line" style="width: 3px; background: rgba(255,255,255,0.2);"></div>
                        </div>
                    </div>

                    <!-- النجوم -->
                    <div class="d-flex flex-column align-items-center gap-1">
                        <i class="fa-solid fa-star text-warning" style="font-size: 0.6rem;"></i>
                        <i class="fa-solid fa-star text-warning" style="font-size: 0.85rem;"></i>
                        <i class="fa-solid fa-star" style="font-size: 0.6rem; color: #fde68a;"></i>
                    </div>
                </div>
            </div>

            <!-- الشارة العائمة -->
            <div class="floating-badge d-flex align-items-center justify-content-center rounded-circle shadow-sm">
                <i class="fa-solid fa-exclamation small fw-bold"></i>
            </div>
        </div>
    </div>
    <!-- تأثير التوهج -->
    <div class="glow-effect"></div>
</div>