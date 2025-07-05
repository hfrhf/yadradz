@extends('base')

@section('title', 'خطأ في الخادم الداخلي')
<style>
/* ضع الستايل الخاص بك هنا */
</style>
@section('content')
<div class="content-custom-error">
    <div class="error-page">
        <h1 class="err-title">500</h1>
        <h2 class="err-text">خطأ في الخادم الداخلي</h2>
        <p class="err-pr">
            عذراً، حدث خطأ غير متوقع على الخادم. يرجى المحاولة لاحقاً.
        </p>
        <a class="bold btn-err-go-home" href="{{ route('store') }}">
            الصفحة الرئيسية
        </a>
    </div>
</div>
@endsection
