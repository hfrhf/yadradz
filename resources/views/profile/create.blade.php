@extends('dashboard.dashboard')

@section('title', 'إضافة مستخدم جديد')

@include('dashboard.sidebar')

@section('content')

<div class="container-fluid px-3 px-md-4">
    <div class="card card-custom">
        <div class="card-header">
            <h4 class="card-title">إضافة مستخدم جديد</h4>
        </div>
        <div class="card-body p-4">

            {{-- رسالة النجاح --}}
            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            {{-- عرض الأخطاء --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('profile.store') }}" method='post'>
                @csrf

                {{-- الحقول الأساسية --}}
                <div class="mb-3">
                    <label class="form-label" for="name">الاسم:</label>
                    <input class="form_control_custom" type="text" id="name" name="name" value="{{ old('name') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="email">البريد الإلكتروني:</label>
                    <input class="form_control_custom" type="email" id="email" name="email" value="{{ old('email') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="password">كلمة المرور:</label>
                    <input class="form_control_custom" type="password" id="password" name="password" required>
                </div>

                <div class="mb-4">
                    <label class="form-label" for="role_selector">الدور:</label>
                    <select class="form_control_custom" name="role" id="role_selector">
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" @selected(old('role') == $role->name)>{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- إعدادات خاصة بمؤكد الطلبيات --}}
                <div id="confirmer_settings_wrapper" style="display: none;">
                    <hr class="my-4">
                    <h5>إعدادات مؤكد الطلبيات</h5>

                    <div class="mb-3">
                        <label for="payment_type_selector" class="form-label">نظام الدفع</label>
                        <select name="confirmer_payment_type" id="payment_type_selector" class="form_control_custom">
                            <option value="">-- لا يوجد --</option>
                            <option value="per_order" @selected(old('confirmer_payment_type') == 'per_order')>حسب الطلب</option>
                            <option value="monthly_salary" @selected(old('confirmer_payment_type') == 'monthly_salary')>راتب شهري</option>
                        </select>
                    </div>

                    {{-- حقول الدفع حسب الطلب --}}
                    <div id="per_order_wrapper" style="display: none;">
                        <div class="mb-3">
                            <label for="confirmer_payment_rate_per_order" class="form-label">عمولة التأكيد</label>
                            <input type="number" step="0.01" name="confirmer_payment_rate_per_order" class="form_control_custom" value="{{ old('confirmer_payment_rate_per_order') }}">
                        </div>
                        <div class="mb-3">
                            <label for="confirmer_cancellation_rate" class="form-label">مكافأة الإلغاء</label>
                            <input type="number" step="0.01" name="confirmer_cancellation_rate" class="form_control_custom" value="{{ old('confirmer_cancellation_rate') }}">
                        </div>
                    </div>

                    {{-- حقول الراتب الشهري --}}
                    <div id="monthly_salary_wrapper" style="display: none;">
                         <div class="mb-3">
                            <label for="confirmer_payment_rate_monthly" class="form-label">قيمة الراتب الشهري</label>
                            <input type="number" step="0.01" name="confirmer_payment_rate_monthly" class="form_control_custom" value="{{ old('confirmer_payment_rate_monthly') }}">
                        </div>
                        <div class="mb-3">
                            <label for="salary_payout_day_input_create" class="form-label">يوم استحقاق الراتب (1-28)</label>
                            <input type="number" name="salary_payout_day" id="salary_payout_day_input_create" class="form_control_custom" min="1" max="28" value="{{ old('salary_payout_day') }}" aria-describedby="payout_day_helper_create">
                            <small id="payout_day_helper_create" class="form-text text-muted"></small>
                        </div>
                    </div>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-lg" style="background-color: #6f42c1; color: white; font-weight: bold;">إضافة المستخدم</button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // جلب العناصر من الـ DOM
    const roleSelector = document.getElementById('role_selector');
    const paymentTypeSelector = document.getElementById('payment_type_selector');
    const confirmerSettingsWrapper = document.getElementById('confirmer_settings_wrapper');
    const monthlySalaryWrapper = document.getElementById('monthly_salary_wrapper');
    const perOrderWrapper = document.getElementById('per_order_wrapper');
    const payoutDayInput = document.getElementById('salary_payout_day_input_create');
    const payoutDayHelper = document.getElementById('payout_day_helper_create');

    // دالة لتحديث النص المساعد ليوم دفع الراتب
    function updateHelperText() {
        if (!payoutDayInput) return;
        const day = parseInt(payoutDayInput.value, 10);
        payoutDayHelper.textContent = (day >= 1 && day <= 28) ? 'سيتم احتساب الراتب في يوم ' + day + ' من كل شهر.' : '';
    }

    // دالة لإظهار أو إخفاء الحقول بناءً على الاختيارات
    function updateVisibility() {
        const selectedRole = roleSelector.value.toLowerCase().trim();
        const selectedPaymentType = paymentTypeSelector.value;

        // التحقق إذا كان الدور هو "confirmer"
        if (selectedRole === 'confirmer') {
            confirmerSettingsWrapper.style.display = 'block';

            // التحقق من نظام الدفع المختار
            if (selectedPaymentType === 'monthly_salary') {
                monthlySalaryWrapper.style.display = 'block';
                perOrderWrapper.style.display = 'none';
                updateHelperText(); // تحديث النص المساعد
            } else if (selectedPaymentType === 'per_order') {
                monthlySalaryWrapper.style.display = 'none';
                perOrderWrapper.style.display = 'block';
            } else {
                monthlySalaryWrapper.style.display = 'none';
                perOrderWrapper.style.display = 'none';
            }
        } else {
            confirmerSettingsWrapper.style.display = 'none';
        }
    }

    // إضافة المستمعين للأحداث
    roleSelector.addEventListener('change', updateVisibility);
    paymentTypeSelector.addEventListener('change', updateVisibility);
    if (payoutDayInput) {
        payoutDayInput.addEventListener('input', updateHelperText);
    }

    // استدعاء الدالة عند تحميل الصفحة لضبط الحالة الأولية
    updateVisibility();
});
</script>
@endsection
