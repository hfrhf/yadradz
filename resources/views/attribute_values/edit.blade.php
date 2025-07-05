@extends('dashboard.dashboard')

@section('title', 'تعديل القيمة')

@include('dashboard.sidebar')

@section('content')

<div class="container-fluid px-3 px-md-4">
    <div class="card card-custom">
        <div class="card-header">
            <h4 class="card-title">تعديل القيمة</h4>
        </div>
        <div class="card-body p-4">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('attribute-values.update', $attributeValue->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- We pass the attribute_id as a hidden field because it should not be changed --}}
                <input type="hidden" name="attribute_id" value="{{ $attributeValue->attribute_id }}">

                <div class="mb-3">
                    <label class="form-label">الخاصية:</label>
                    {{-- Display the attribute name as read-only text --}}
                    <input class="form_control_custom" type="text" value="{{ $attributeValue->attribute->localized_name }}" readonly>
                </div>

                <div class="mb-3">
                    {{--
                        Check the base name of the attribute.
                        The name 'اللون' is the one we set as locked in our seeder.
                    --}}
                    @if ($attributeValue->attribute->name === 'اللون')
                        {{-- If it's the "Color" attribute, use our Blade component --}}
                        <x-color-input name="value" label="القيمة" :value="$attributeValue->value" />
                    @else
                        {{-- For any other attribute, use a standard text input --}}
                        <div>
                            <label class="form-label" for="value">القيمة:</label>
                            <input class="form_control_custom" type="text" id="value" name="value" value="{{ old('value', $attributeValue->value) }}" required>
                        </div>
                    @endif
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-lg" style="background-color: #6f42c1; color: white; font-weight: bold;">تحديث القيمة</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection