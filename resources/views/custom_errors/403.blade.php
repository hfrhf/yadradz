@extends('base')

@section('title', 'الوصول ممنوع')
<style>
/* ضع الستايل الخاص بك هنا */
</style>
@section('content')
<div class="content-custom-error">
    <div class="error-page">
        <h1 class="err-title">403</h1>
        <h2 class="err-text">الوصول ممنوع</h2>
        <p class="err-pr">
            عذراً، ليس لديك الصلاحية للوصول إلى هذه الصفحة.
        </p>
        <a class="bold btn-err-go-home" href="{{ route('store') }}">
            الصفحة الرئيسية
        </a>
    </div>
</div>
@endsection
