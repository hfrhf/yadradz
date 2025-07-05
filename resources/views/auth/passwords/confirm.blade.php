@extends('base')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="login-card">
                <div class="logo-container">
                    <img src="{{asset('storage/'.$setting->logo)}}" alt="Logo" class="logo-login">
                </div>

                <div class="login-body">
                    <p>الرجاء تأكيد كلمة المرور الخاصة بك قبل المتابعة.</p>

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="form-group">
                            <input id="password" type="password" class="form-control custom-input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="كلمة السر ....">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt-2">
                            <button type="submit" class="custom-btn">
                                تأكيد كلمة المرور
                            </button>

                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    نسيت كلمة السر؟
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
