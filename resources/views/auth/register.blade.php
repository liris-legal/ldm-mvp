@extends('layouts.auth')
@section('title', 'Register LDM')
@section('content')
<div class="register container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center"><img src="{{ asset('images/logo.svg') }}" alt=""></div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register.post') }}">
                        @csrf
{{--                        <div class="form-group row">--}}
{{--                            <div class="col-md-12 text-center">--}}
{{--                                <input id="name" type="text" class="fix-form-control form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="あなたの名を入力してください" autofocus>--}}

{{--                                @error('name')--}}
{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                        </div>--}}

                        <div class="form-group row">
                            <div class="col-md-12 text-center">
                                <input id="email" type="email" class="fix-form-control form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="メールアドレスを入力してください">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12 text-center">
                                <input id="password" type="password" class="fix-form-control form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="パスワードを入力してください">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12 text-center">
                                <input id="password-confirm" type="password" class="fix-form-control form-control" name="password_confirmation" required autocomplete="new-password" placeholder="もう一度パスワードを入力してください">
                            </div>
                        </div>

                        <div class="form-group row mb-0 btn-add-form-group">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('登録する') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
