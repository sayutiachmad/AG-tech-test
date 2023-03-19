@extends('layouts.app')

@once
    @push('script')
        <script src="{{ asset('assets/custom/js/auth/login.js') }}"></script>
    @endpush
@endonce

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">

                    <div class="alert alert-danger" role="alert" id="login-alert" style="display:none;">
                        <span id="login-alert-text"></span>
                    </div>

                    <form method="POST" action="{{ route('app.index') }}"  id="form-login">
                        @csrf

                        <div class="row mb-3">
                            <label for="username" class="col-md-4 col-form-label text-md-end">{{ __('Username / Email') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="none" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row my-3">
                            <div class="d-grid gap-2 col-4 mx-auto">
                                <label>Not a member yet? <a href="{{ route('register') }}" class="btn btn-link" id='btn-register'>Register</a></label>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="d-grid gap-2 col-4 mx-auto">
                               <button type="submit" class="btn btn-primary btn-fill" id="do-login">
                                    {{ __('Login') }}
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
