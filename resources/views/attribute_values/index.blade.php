@extends('dashboard.dashboard')
@section('title','قيم الخصائص')

@include('dashboard.sidebar')
@section('content')

<a class="btn-create" href="{{ route('attribute-values.create') }}">إضافة قيمة</a>
<div class="container-fluid px-3 px-md-4">
    <div class="card card-custom">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" class="text-center">#</th>
                            <th scope="col">القيمة</th>
                            <th scope="col">الخاصية</th>
                            <th scope="col" class="text-center">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($values as $value)
                            <tr>
                                <td class="text-center align-middle">{{ $loop->iteration }}</td>

                                {{-- Here is the conditional display for the value --}}
                                <td class="align-middle">
                                    @if ($value->attribute->name === 'اللون')
                                        <div class="d-flex align-items-center gap-3">
                                            {{-- The color swatch --}}
                                            <span style="display: inline-block; width: 30px; height: 30px; border-radius: 5px; background-color: {{ $value->value }}; border: 1px solid #dee2e6;"></span>
                                            {{-- The hex code --}}
                                            <span style="font-family: monospace;">{{ $value->value }}</span>
                                        </div>
                                    @else
                                        {{-- Display regular text for other attributes --}}
                                        {{ $value->value }}
                                    @endif
                                </td>

                                <td class="align-middle">{{ $value->attribute->localized_name }}</td>

                                <td class="text-center align-middle">
                                    <a href="{{ route('attribute-values.edit', $value->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i> تعديل
                                    </a>
                                    <form action="{{ route('attribute-values.destroy', $value->id) }}" method="post" class="d-inline" onsubmit="return confirm('هل أنت متأكد من رغبتك في الحذف؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i> حذف
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">لا توجد قيم مضافة حاليًا.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection