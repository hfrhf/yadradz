@extends('dashboard.dashboard')
@section('title','طلبات العملاء')

@include('dashboard.sidebar')

@section('content')
@php
// قمنا بإضافة أيقونة لكل حالة
$statuses = [
    'pending' => ['label' => 'قيد الانتظار', 'color' => 'info', 'icon' => 'fas fa-bell'],
    'confirmed' => ['label' => 'تم التأكيد', 'color' => 'primary', 'icon' => 'fas fa-check-circle'],
    'unconfirmed' => ['label' => 'فشل التأكيد', 'color' => 'warning', 'icon' => 'fas fa-phone-slash'],
    'processing' => ['label' => 'قيد التجهيز', 'color' => 'info', 'icon' => 'fas fa-cogs'],
    'shipped' => ['label' => 'تم الشحن', 'color' => 'secondary', 'icon' => 'fas fa-shipping-fast'],
    'out_for_delivered' => ['label' => 'في طريقه للزبون', 'color' => 'info', 'icon' => 'fas fa-truck'],
    'delivered' => ['label' => 'تم التسليم', 'color' => 'success', 'icon' => 'fas fa-check-double'],
    'cancelled_store' => ['label' => 'ملغي من المتجر', 'color' => 'dark', 'icon' => 'fas fa-store-slash'],
    'cancelled_customer' => ['label' => 'ملغي من الزبون', 'color' => 'dark', 'icon' => 'fas fa-user-times'],
    'returned' => ['label' => 'مرجعة', 'color' => 'danger', 'icon' => 'fas fa-undo'],
];
@endphp

<style>
/* ... (هنا الاستايلات الخاصة بك، لم تتغير) ... */
.fs-d{
    font-size: 12px;
}
.status-card {
    display: flex;
    align-items: center;
    padding: 1rem;
    border-radius: 0.5rem;
    text-decoration: none;
    color: #333;
    font-weight: 500;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    border: 1px solid transparent;
}
.status-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
.status-card i {
    font-size: 1.2rem;
}
.status-card .badge {
    margin-inline-start: auto;
    font-size: 0.9rem;
}
.status-card.border-primary { background-color: rgba(var(--bs-primary-rgb), 0.1); }
.status-card.border-success { background-color: rgba(var(--bs-success-rgb), 0.1); }
.status-card.border-info { background-color: rgba(var(--bs-info-rgb), 0.1); }
.status-card.border-warning { background-color: rgba(var(--bs-warning-rgb), 0.1); }
.status-card.border-danger { background-color: rgba(var(--bs-danger-rgb), 0.1); }
.status-card.border-secondary { background-color: rgba(var(--bs-secondary-rgb), 0.1); }
.status-card.border-dark { background-color: rgba(var(--bs-dark-rgb), 0.1); }
</style>

<h4 class="mb-4">طلبات العملاء</h4>

{{-- ملخص الطلبات (لم يتغير) --}}
<div class="mb-4">
    <h5 class="mb-3">ملخص الطلبات</h5>
    <div class="row">
        @foreach ($statuses as $statusValue => $statusDetails)
            <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
                <a href="{{ request()->fullUrlWithQuery(['status' => $statusValue]) }}"
                   class="status-card border-{{ $statusDetails['color'] }} text-{{ $statusDetails['color'] }}">
                    <i class="{{ $statusDetails['icon'] }} me-2"></i>
                    <span>{{ $statusDetails['label'] }}</span>
                    <span class="badge bg-{{ $statusDetails['color'] }}">
                        {{ $statusCounts[$statusValue] ?? 0 }}
                    </span>
                </a>
            </div>
        @endforeach
    </div>
</div>

{{-- فورم الفلترة (لم يتغير ومفصول عن فورم الإرسال) --}}
<form method="GET" class="row mb-3 align-items-center">
    <div class="col-md-3">
        <input type="text" name="search" class="form-control" placeholder="بالاسم او منتج أو الهاتف" value="{{ request('search') }}">
    </div>
    <div class="col-md-3">
        <select name="status" class="form-select">
            <option value="">جميع الحالات</option>
            @foreach ($statuses as $statusValue => $statusDetails)
                <option value="{{ $statusValue }}" {{ request('status') === $statusValue ? 'selected' : '' }}>
                    {{ $statusDetails['label'] }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <select name="state" class="form-select">
            <option value=""> الولايات</option>
            @foreach ($shippings as $shipping)
                <option value="{{ $shipping->id }}" {{ request('state') == $shipping->id ? 'selected' : '' }}>
                    {{ $shipping->state}}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary w-100">🔍 تصفية</button>
    </div>
</form>

{{-- الفورم الخاص بإرسال الطلبات المحددة --}}
<form action="{{ route('customer-orders.bulkShip') }}" method="POST" id="bulk-ship-form">
    @csrf
    {{-- زر الإرسال --}}
    <div class="mb-3">
        <button type="submit" class="btn btn-success">
            <i class="fas fa-truck me-1"></i> إرسال المحدد لشركة الشحن
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped minimaze-table">
            <thead>
                <tr>
                    <th><input type="checkbox" id="select-all-checkbox"></th>
                    <th>#</th>
                    <th>العميل</th>
                    <th>الهاتف</th>
                    <th>المنتج</th>
                    <th>الكمية</th>
                    <th>السعر الإجمالي</th>
                    <th>نوع التوصيل</th>
                    <th>الولاية / البلدية</th>
                    <th>تاريخ الطلب</th>
                    <th>الحالة</th>
                    <th>تاريخ التسليم</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    @php
                        $statusInfo = $statuses[$order->status] ?? ['label' => $order->status, 'color' => 'secondary'];
                        $isShippable = in_array($order->status, ['confirmed', 'processing']);
                    @endphp
                    <tr>
                        <td>
                            <input type="checkbox" class="order-checkbox" name="order_ids[]" value="{{ $order->id }}"
                                @if(!$isShippable) disabled title="لا يمكن شحن هذا الطلب لأنه في حالة {{ $statusInfo['label'] }}" @endif
                            >
                        </td>
                        <td style="background-color: #303036;color:white;text-align:center">{{ $loop->iteration }}</td>
                        <td>
                            <a href="{{ route('customer-orders.show', $order->id) }}">{{ $order->fullname }}</a>
                            @if($order->tracking_number)
                                <br><small class="text-muted">تتبع: {{ $order->tracking_number }}</small>
                            @endif
                        </td>
                        <td>{{ $order->phone }}</td>
                        <td>{{ optional($order->product)->name }}</td>
                        <td>{{ $order->quantity }}</td>
                        <td>{{ number_format($order->total_price, 2) }} دج</td>
                        <td>
                            @if($order->delivery_type == 'to_home')
                                🏠 للمنزل
                            @else
                                📦 للمكتب
                            @endif
                        </td>
                        <td>{{ $order->state->state }} / {{ $order->municipality->name }}</td>
                        <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            <span class="badge bg-{{ $statusInfo['color'] }}">
                                {{ $statusInfo['label'] }}
                            </span>
                        </td>
                        <td>{{ $order->delivered_at ? $order->delivered_at->format('Y-m-d H:i') : '' }}</td>
                        <td>
                            <a href="{{ route('customer-orders.edit', $order->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                            @if ($company->slug == 'ecotrack')
                            @if($order->tracking_number)
                                <a href="{{ route('customer-orders.printLabel', $order->id) }}" class="btn btn-sm btn-warning" target="_blank" title="طباعة الفاتورة">
                                    <i class="fas fa-print"></i>
                                </a>
                                @endif
                            @endif

                            {{-- ✅  بداية التعديل: زر الحذف الآن يفتح نافذة منبثقة --}}

                            <button type="button" class="btn btn-sm btn-danger delete-btn"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteConfirmationModal"
                            data-action="{{ route('customer-orders.destroy', $order->id) }}">
                        <i class="fas fa-trash"></i>
                    </button>


                            {{-- نهاية التعديل --}}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="13" class="text-center">لا توجد طلبات حالياً</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</form>

{{-- روابط الصفحات (لم تتغير) --}}
<div class="mt-3">
    {{ $orders->links() }}
</div>

{{-- ✅ بداية الإضافة: نافذة تأكيد الحذف المنبثقة (Modal) --}}
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">تأكيد الحذف</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        هل أنت متأكد من رغبتك في حذف هذا الطلب؟ لا يمكن التراجع عن هذا الإجراء.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
        {{-- هذا النموذج الآن منفصل تماماً وغير متداخل --}}
        <form id="delete-form" method="POST" action="">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">نعم، قم بالحذف</button>
        </form>
      </div>
    </div>
  </div>
</div>


{{-- كود JavaScript --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const selectAllCheckbox = document.getElementById('select-all-checkbox');
    const bulkShipForm = document.getElementById('bulk-ship-form');

    // --- كود الشحن الجماعي (لم يتغير) ---
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function () {
            const orderCheckboxes = document.querySelectorAll('.order-checkbox:not(:disabled)');
            orderCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    }

    if (bulkShipForm) {
        bulkShipForm.addEventListener('submit', function (e) {
            const selectedCount = document.querySelectorAll('.order-checkbox:checked').length;
            if (selectedCount === 0) {
                e.preventDefault();
                alert('يرجى تحديد طلب واحد على الأقل لإرساله.');
                return;
            }

            const confirmation = confirm(`هل أنت متأكد من إرسال ${selectedCount} طلبات إلى شركة الشحن؟ لا يمكن التراجع عن هذه العملية.`);
            if (!confirmation) {
                e.preventDefault();
            }
        });
    }

    // --- ✅ بداية الإضافة: كود التعامل مع نافذة الحذف ---
    const deleteModal = document.getElementById('deleteConfirmationModal');
    if (deleteModal) {
        const deleteForm = document.getElementById('delete-form');

        // هذا الحدث يتم تفعيله مباشرة قبل عرض النافذة
        deleteModal.addEventListener('show.bs.modal', function (event) {
            // الزر الذي قام بتفعيل النافذة
            const button = event.relatedTarget;

            // استخراج رابط الحذف من خاصية data-action
            const action = button.getAttribute('data-action');

            // تحديث خاصية action في نموذج الحذف داخل النافذة
            deleteForm.setAttribute('action', action);
        });
    }
    // --- نهاية الإضافة ---
});
</script>

@endsection