@extends('dashboard.dashboard')
@section('title','المنتجات')



@include('dashboard.sidebar')
@section('content')
<a class="btn-create" href={{route('product.create')}}>اضافة منتج</a>

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead >
            <tr>
                <th style="" >معرف</th>
                <th>الاسم</th>
                <th>الوصف</th>

                <th>السعر</th>
                <th>الكمية</th>
                <th>الفئة</th>
                <th>الحالة</th>
                <th>الصورة</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $index => $product)
            <tr>
                <td style="background-color: #303036;color:white;text-align:center" >{{$products->firstItem() + $loop->index}}</td>
                <td><a href="{{route('product.show',$product->id)}}">{{$product->name}}</a></td>
                <td>{{Str::limit(strip_tags($product->description,40))}}</td>
                <td class="price-color">{{$product->price}}$</td>
                <td>{{$product->quantity}}</td>
                <td>{{$product->category->name}}</td>
                <td class=" fw-bold {{  $product->is_active ? 'text-success' : 'text-danger' }}">{{$product->is_active ? 'مفعل' : 'غير مفعل'}}</td>
                <td>
                    <img src="{{asset('storage/'.$product->image)}}" alt="" class="img-fluid" style="max-width: 80px;">
                </td>
                <td>
                    <div class="d-flex justify-content-center align-items-center gap-2">
                        <form>
                            <a href={{ route('product.edit', $product->id) }} class="btn btn-primary">تحديث</a>
                        </form>
                        <form action={{route('product.destroy',$product->id)}} method='post'>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">حذف</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td class="text-center" colspan="8">لا توجد منتجات</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>


{{$products->links()}}

@endsection

