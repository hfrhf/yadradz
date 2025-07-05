@extends('base')

@section('title', 'انتهاء صلاحية الصفحة')
<style>
/* ضع الستايل الخاص بك هنا */
</style>
@section('content')
<div class="content-custom-error">
    <div class="error-page">
        <h1 class="err-title">419</h1>
        <h2 class="err-text">انتهاء صلاحية الصفحة</h2>
        <p class="err-pr">
            عذراً، انتهت صلاحية الصفحة. يرجى إعادة المحاولة.
        </p>
        <a class="bold btn-err-go-home" href="{{ route('store') }}">
            الصفحة الرئيسية
        </a>
    </div>
</div>
@endsection
