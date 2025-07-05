<div class="col-md-6">
    <div class="mb-4">
        <label for="{{ $name }}" class="form-label">{{ $label }}:</label>
        <div class="input-group color-picker-group">
            {{-- نستخدم old() لاستعادة القيمة السابقة في حال فشل التحقق من صحة البيانات --}}
            <input type="color" class="form-control form-control-color color-picker-swatch" value="{{ old($name, $value) }}" title="اختر لونا">
            <input type="text" class="form_control_custom color-picker-hex" name="{{ $name }}" id="{{ $name }}" value="{{ old($name, $value) }}">
        </div>
    </div>
</div>