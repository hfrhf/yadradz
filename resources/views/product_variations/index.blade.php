@extends('dashboard.dashboard')
@section('title','توليفات المنتجات')

@include('dashboard.sidebar')
@section('content')

<a class="btn-create" href="{{ route('product-variations.create') }}">إضافة توليفة</a>

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>المنتج</th>
                <th>السمات</th>
                <th>السعر</th>
                <th>الكمية</th>
                <th>SKU</th>
                <th>إجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($variations as $variation)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $variation->product->name }}</td>
                    <td>
                        @foreach ($variation->attributeValues as $value)
                            <span class="badge bg-secondary">{{ $value->attribute->name }}: {{ $value->value }}</span>
                        @endforeach
                    </td>
                    <td>{{ $variation->price }}</td>
                    <td>{{ $variation->quantity }}</td>
                    <td>{{ $variation->sku }}</td>
                    <td>
                        <a href="{{ route('product-variations.edit', $variation->id) }}" class="btn btn-primary">تعديل</a>
                        <form action="{{ route('product-variations.destroy', $variation->id) }}" method="post" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger">حذف</button>
                        </form>
                    </td>
                </tr>
            @empty

            <tr><td colspan="12" class="text-center">لا توجد قيم</td></tr>

            @endforelse

        </tbody>
    </table>
</div>

@endsection
