@extends('base')

@section('title', trans('store.contact_us.page_title'))

    <style>
body {
    background-color: #f4f7f6;
}

.contact-title {
    color: var(--title-color);
}

.contact-subtitle {
    color: var(--title-color);
}

.contact-card {
    background-color: #fff;
    border: none;
    border-radius: 1rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.07);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    padding: 2rem 1.5rem;
}

.contact-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
}

.contact-icon {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    background-color: rgba(13, 110, 253, 0.1); /* لون أزرق شفاف */
    background-color: var(--primary-color-transparent, rgba(13, 110, 253, 0.1));
    color: var(--primary-color);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.contact-card:hover .contact-icon {
    background-color: var(--primary-color);
    color: #fff;
}

.contact-card .card-title {
    color: var(--title-color);
    font-weight: 700;
}

.contact-card .card-text {
    color: var(--title-color);
}

.contact-btn {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
    font-weight: bold;
    padding: 0.6rem 1.5rem;
    border-radius: 50px;
    transition: background-color 0.3s ease, border-color 0.3s ease;
}

.social-btn {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background-color: #eef2f7;
    color: var(--title-color);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.3s ease;
}

.social-btn:hover {
    background-color: var(--primary-color);
    color: #fff;
    transform: scale(1.1);
}

    </style>


@section('content')
<div class="contact-page-container">
    <div class="container py-5">

        <!-- العنوان الرئيسي -->
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold contact-title">{{ trans('store.contact_us.main_heading') }}</h1>
            <p class="lead contact-subtitle">{{ trans('store.contact_us.sub_heading') }}</p>
        </div>

        <div class="row justify-content-center g-4">

            <!-- بطاقة الهاتف -->
            @if($adminInfo->phone)
            <div class="col-md-6 col-lg-4">
                <div class="contact-card text-center h-100">
                    <div class="card-body">
                        <div class="contact-icon mx-auto mb-3">
                            <i class="fas fa-phone fa-2x"></i>
                        </div>
                        <h4 class="card-title">{{ trans('store.contact_us.phone') }}</h4>
                        <p class="card-text fs-5" dir="ltr">{{ $adminInfo->phone }}</p>
                        <a href="tel:{{ $adminInfo->phone }}" class="btn btn-primary contact-btn mt-3">{{ trans('store.contact_us.call_now') }}</a>
                    </div>
                </div>
            </div>
            @endif

            <!-- بطاقة البريد الإلكتروني -->
            @if($adminInfo->email)
            <div class="col-md-6 col-lg-4">
                <div class="contact-card text-center h-100">
                    <div class="card-body">
                        <div class="contact-icon mx-auto mb-3">
                            <i class="fas fa-envelope fa-2x"></i>
                        </div>
                        <h4 class="card-title">{{ trans('store.contact_us.email') }}</h4>
                        <p class="card-text fs-5">{{ $adminInfo->email }}</p>
                        <a href="mailto:{{ $adminInfo->email }}" class="btn btn-primary contact-btn mt-3">{{ trans('store.contact_us.send_email') }}</a>
                    </div>
                </div>
            </div>
            @endif

            <!-- بطاقة الشبكات الاجتماعية -->
            @if($adminInfo->facebook || $adminInfo->twitter)
            <div class="col-md-6 col-lg-4">
                <div class="contact-card text-center h-100">
                    <div class="card-body">
                        <div class="contact-icon mx-auto mb-3">
                            <i class="fas fa-share-alt fa-2x"></i>
                        </div>
                        <h4 class="card-title">{{ trans('store.contact_us.follow_us') }}</h4>
                        <p class="card-text">{{ trans('store.contact_us.social_media_text') }}</p>
                        <div class="d-flex justify-content-center mt-4">
                            @if($adminInfo->facebook)
                                <a href="{{ $adminInfo->facebook }}" target="_blank" class="social-btn mx-2"><i class="fab fa-facebook-f fa-lg"></i></a>
                            @endif
                            @if($adminInfo->twitter)
                                <a href="{{ $adminInfo->twitter }}" target="_blank" class="social-btn mx-2"><i class="fab fa-twitter fa-lg"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
