@extends('layouts.app')

@section('content')
<style>
    .logo{
        font-weight: 900;
        text-shadow: 2px 2px 2px rgb(110, 109, 109);
        color:#1c3250
    }
    .card{
        background: white;
    }
</style>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div align="center" class="row g-1">
                                <div class="col-md-12 mt-3">
                                    <h1 class="logo">INICON S.A. </h1>
                                </div>
                                <div class="col-md-12">
                                    <img src="{{ asset('IMG/log.jpg') }}" alt="" width="110"
                                        height="130">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <h3><strong>Iniciar sessión </strong></h3>
                                </div>
                            </div>
                            @if (session('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error')}}
                                </div>
                            @endif
                            <div class="row g-4 ">
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('email') is-invalid @enderror"
                                            name="email" id="floatingInputInvalid" value="{{ old('email') }}" required
                                            autofocus>
                                        <label for="floatingInputInvalid"><i class="fas fa-envelope"></i> Correo
                                            electronico</label>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                            name="password" id="floatingInputInvalid" placeholder="...">
                                        <label for="floatingInputInvalid"> <i class="fas fa-key"></i> {{ __('Password') }}
                                        </label>
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                                <div class="d-grid gap-2 col-8 mx-auto">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Login') }}
                                    </button>
                                </div>
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link mt-3" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
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
