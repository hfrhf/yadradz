@extends('base')

@section('content')

    <div class="row h-100vh justify-content-center">
        <div class="col-md-8 margin-auto ">
            <div class="login-card ">
                <div class="logo-container">
                    <img src="{{asset('storage/'.$setting->logo)}}" alt="Logo" class="logo-login">
                </div>

                <div class="login-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group">
                            <input id="email" type="email" class="form-control custom-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="البريد الالكتروني ....">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input id="password" type="password" class="form-control custom-input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="كلمة السر ....">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="">
                                <input style="margin-left:8px;"  class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    تذكرني
                                </label>
                            </div>
                        </div>

                        <div class="form-group mt-2">
                            <button type="submit" class="custom-btn">
                                تسجيل الدخول
                            </button>

                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    نسيت كلمة السر ؟
                                </a>
                            @endif
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
