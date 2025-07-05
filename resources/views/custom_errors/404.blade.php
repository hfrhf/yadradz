@extends('base')

@section('title', 'الصفحة غير موجودة')
<style>

</style>
@section('content')
<div class="content-custom-error">
    <div class="error-page" >
        <h1 class="err-title" >404</h1>
        <h2 class="err-text">الصفحة غير موجودة</h2>
        <p class="err-pr">
            عذراً، الصفحة التي تحاول الوصول إليها غير متوفرة.
        </p>
        <a class="bold btn-err-go-home" href="{{ route('store')}}" >
          الصفحة الرئيسية
        </a>
    </div>
</div>
@endsection


