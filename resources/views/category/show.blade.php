@extends('dashboard.dashboard')
@section('title',$category->name)
    
<div class="row">
    <div class="col-2">
        @include('dashboard.sidebar')
    </div>
    <div class="col-10">
        @section('content')
        <div class="table-responsive">
            <table class="table table-bordered table-striped mt-4">
                <thead>
                    <tr>
                        <th>معرف</th>
                        <th>الاسم</th>
                        <th>السعر</th>
                        <th>الصورة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($category->product as $index => $product)
                    <tr>
                        <td style="background-color: #303036;color:white;text-align:center" >{{$index+1}}</td>
                        <td>{{$product->name}}</td>
                        <td class="price-color">{{$product->price}}$</td>
                        <td>
                            <img src="{{asset('storage/'.$product->image)}}" class="img-fluid" style="max-width: 80px;" alt="">
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
                        <td class="text-center" colspan="5">لا توجد منتجات</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @endsection
    </div>
   

</div>


