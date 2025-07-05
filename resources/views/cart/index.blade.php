@extends('base')
@section('title','السلة')


@section('content')
@if (session('error'))
<div class="alert alert-danger" role="alert">
    {{ session('error') }}
</div>
@endif
@if (session('success'))
<div class="alert alert-success" role="alert">
    {{ session('success') }}
</div>
@endif
<div class="flex-complet-between">
    <h4 class="title-cart">سلة المشتريات</h4>
    <button class=" btn-total"> الاجمالي : ${{ number_format($cart->total, 2) }} </button>
</div>
@if($cart->items->isEmpty())
<div class="content-empty-cart">
    <div class="empty-cart mt-3">
        <p>سلة التسوق فارغة</p>
    </div>
</div>
@else
@foreach($cart->items as $item)
<div class="shopping-cart mt-5">
   <div class="shopping-img">

    <a href="{{ route('store.show', $item->product->id) }}"><img src="{{asset('storage/'.$item->product->image)}}" alt=""></a>
   </div>
   <div class="shopping-info">
    <h1> {{ $item->product->name }}</h1>
    <p>{{ $item->product->category->name }}</p>

   </div>
   <div class="shopping-price">
    <h1>${{ number_format($item->price, 2) }}</h1>
   </div>
   <div class="shopping-btn">
    @auth
<form action="{{ route('cart.remove', $item->id) }}" method="POST">
@endauth

@guest
<form action="{{ route('cart.remove', $item->product->id) }}" method="POST">
@endguest


        @csrf
        @method('DELETE')
        <button type="submit" class="btn-delete">حذف</button>
    </form>

   </div>

</div>

@endforeach
<div class="buy-card mt-5">

</div>
@endif

@endsection

