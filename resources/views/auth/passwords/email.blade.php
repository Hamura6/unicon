@extends('layouts.app')

@section('content')
<style>
    .logo{
        font-weight: 900;
        text-shadow: 2px 2px 2px rgb(110, 109, 109);
        color:#1c3250
    }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div align="center" class="row g-1">
                            <div class="col-md-12 mt-3">
                                <h1 class="logo">UNICON S.A. </h1>
                            </div>
                            <div class="col-md-12">
                                <img src="{{ asset('IMG/log.jpg') }}" alt="" width="110"
                                    height="130">
                            </div>
                            <div class="col-md-12 mb-3">
                                <h3><strong>Recuperar contraseña </strong></h3>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">Ingrese la contraseña</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Enviar enlace de restablecimiento de contraseña
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
