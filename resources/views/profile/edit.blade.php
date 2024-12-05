<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Unicon S.A.</title>
    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }} ">
    <!-- Scripts -->

    {{--  @vite(['resources/sass/app.scss'])  --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }} ">

    @livewireStyles()
</head>

<body>

    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <div id="app">
        @include('layouts.theme.sidebar')
        @include('layouts.theme.header')
        <main class="py-4">
            <div class="row g-2">
                <div class="col-12">
                    <x-header title='Perfil' />
                </div>
                <div class="col-lg-6 col-md-12">
                    <x-body subtitle='Datos personales'>

                        <form action="{{ route('profile.update.person') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <x-inputFloat value='{{ $user->person->nombre }}' name='nombre' title='Nombres' />
                                </div>
                                <div class="col-md-6">
                                    <x-inputFloat value='{{ $user->person->apellido }}' name='apellido' title='Apellidos' />
                                </div>
                                <div class="col-md-6">
                                    <x-inputFloat value='{{ $user->person->telefono }}' name='telefono' title='Numero de celular'
                                        type='number' />
                                </div>
                                <div class="col-md-6">
                                    <x-inputFloat value='{{ $user->person->ci }}' name='ci' title='Nº de CI.'
                                        type='number' />
                                </div>

                                <div class="col-md-6">
                                    <x-inputFloat value='{{ $user->fecha_n }}' name='fecha_n' title="Fecha de nacimiento"
                                        type='date' />
                                </div>

                                <div class="col-md-6">
                                    <x-inputFloat value='{{ $user->direccion }}' name='direccion' title="Direccion" />
                                </div>
                                <div class="col-12">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <a class="btn btn-secondary " href="{{ route('home') }}"><i
                                                class="fas fa-cancel"></i> Cancelar</a>
                                        <button class="btn btn-success" type="submit"><i class="fas fa-edit"></i>
                                            Guardar</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </x-body>
                </div>
                <div class="col-lg-3 col-md-12">
                    <x-body subtitle='Datos de usuario'>
                        <form action="{{ route('profile.update.user') }}" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="row g-3">
                                <div class="col-12" align="center">
                                    <img src="{{ asset(Auth::user()->imagen) }}" width="90" height="72"
                                        id='picture'>
                                    <div>
                                        <label for="formFile" class="form-label">Imagen</label>
                                        <input class="form-control" type="file" id='file' name='foto'
                                            value='{{ $user->foto }}'>
                                    </div>

                                </div>
                                <div class="col-12">
                                    <x-inputFloat name='email' title='Correo electornico' type='email'
                                        value='{{ $user->email }} '></x-inputFloat>
                                </div>
                                <div class="col-12">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <a class="btn btn-secondary " href="{{ route('home') }}"><i
                                                class="fas fa-cancel"></i> Cancelar</a>
                                        <button class="btn btn-success" type="submit"><i class="fas fa-edit"></i>
                                            Guardar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </x-body>
                </div>

                <div class="col-lg-3 col-md-12">
                    <x-body subtitle='Cambiar contraseña'>
                        <form action="{{ route('profile.update.key') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row g-3">
                                <div class="col-12">
                                    <x-inputFloat name='last_password' title='Contraseña actual' type='password' />
                                </div>
                                <div class="col-12">
                                    <x-inputFloat name='password' title='Nueva contraseña' type='password' />
                                </div>
                                <div class="col-12">
                                    <x-inputFloat name='password_confirmation' title='Confirmar contraseña'
                                        type='password' />
                                </div>
                                <div class="col-12">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <a class="btn btn-secondary " href="{{ route('home') }}"><i
                                                class="fas fa-cancel"></i> Cancelar</a>
                                        <button class="btn btn-success" type="submit"><i class="fas fa-edit"></i>
                                            Guardar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </x-body>
                </div>
            </div>
        </main>
    </div>



    @livewireScripts()
    <script src="{{asset('build/assets/app-XM1nyk2I.js')}}"></script>
    
    <script src="{{asset('js/action.js')}}"></script>
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script>
        document.getElementById("file").addEventListener('change', changeImage);

        function changeImage(event) {
            var file = event.target.files[0];
            var reader = new FileReader();
            reader.onload = (event) => {
                document.getElementById("picture").setAttribute('src', event.target.result);
            };
            reader.readAsDataURL(file);
        }
    </script>
    @if (session('Actuzalizado') == 'OK')
        <script>
            notify({
                "title": "Datos actualizados",
                "text": "Los datos se actualizaron correctamente",
                "icon": "success"
            });
        </script>
    @endif
</body>

</html>
