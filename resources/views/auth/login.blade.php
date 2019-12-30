@extends('layouts.auth')
@section('title', 'Login LDM')
@section('content')
<div class="login container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center"><img src="{{ asset('images/logo.svg') }}" alt=""></div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="email" type="email" placeholder="メールアドレス" class="fix-form-control form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback text-error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="password" type="password" placeholder="パスワード" class="fix-form-control form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback text-error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

{{--                        <div class="form-group row">--}}
{{--                            <div class="col-md-6 offset-md-4">--}}
{{--                                <div class="form-check">--}}
{{--                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>--}}

{{--                                    <label class="form-check-label" for="remember">--}}
{{--                                        {{ __('Remember Me') }}--}}
{{--                                    </label>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

                        <div class="form-group row mb-0 btn-add-form-group">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary d-block">
                                    {{ __('ログイン') }}
                                </button>

{{--                                @if (Route::has('password.request'))--}}
{{--                                    <a class="btn btn-link" href="{{ route('password.request') }}">--}}
{{--                                        {{ __('Forgot Your Password?') }}--}}
{{--                                    </a>--}}
{{--                                @endif--}}
                            </div>
                        </div>
                    </form>
                </div>
                <div class="v-row">
                    <div class="col-12 text-center">
                        <a class="btn dark-link" href="{{ route('register') }}">
                            {{ __('新しいアカウントを作成する。') }}
                        </a>
                    </div>
                </div>
                <div class="v-row">
                    <div class="col-md-4 text-center mr-0-auto">
                        {{ view('notification') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
