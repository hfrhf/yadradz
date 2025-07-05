@extends('dashboard.dashboard')

@section('title', 'إرسال إشعار جديد')
@include('dashboard.sidebar')
@section('content')

<div class="container-fluid px-3 px-md-4">
    <div class="card card-custom">
        <div class="card-header">
            <h4 class="card-title">إرسال إشعار جديد</h4>
        </div>
        <div class="card-body p-4">

            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('notifications.send') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="title" class="form-label">عنوان الإشعار</label>
                    <input type="text" class="form_control_custom" id="title" name="title" value="{{ old('title') }}" required>
                </div>

                <div class="mb-4">
                    <label for="message" class="form-label">نص الرسالة</label>
                    <textarea class="form_control_custom" id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
                </div>

                <fieldset class="mb-3">
                    <legend class="form-label fs-6">إرسال إلى:</legend>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="recipients" id="sendToAll" value="all" checked>
                        <label class="form-check-label" for="sendToAll">جميع المستخدمين</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="recipients" id="sendToSpecific" value="specific">
                        <label class="form-check-label" for="sendToSpecific">مستخدم محدد</label>
                    </div>
                </fieldset>

                <div class="mb-4" id="specificUserSelect" style="display: none;">
                    <label for="user_id" class="form-label">اختر المستخدم</label>
                    <select class="form_control_custom" id="user_id" name="user_id">
                        <option value="">-- اختر مستخدم --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-lg" style="background-color: #6f42c1; color: white; font-weight: bold;">إرسال الإشعار</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const sendToAllRadio = document.getElementById('sendToAll');
    const sendToSpecificRadio = document.getElementById('sendToSpecific');
    const specificUserSelect = document.getElementById('specificUserSelect');

    function toggleUserSelect() {
        if (sendToSpecificRadio.checked) {
            specificUserSelect.style.display = 'block';
        } else {
            specificUserSelect.style.display = 'none';
        }
    }

    sendToAllRadio.addEventListener('change', toggleUserSelect);
    sendToSpecificRadio.addEventListener('change', toggleUserSelect);

    toggleUserSelect();
});
</script>
@endsection
