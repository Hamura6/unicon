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
            <div class="row g-3">
                <x-header title='Reporte de ventas' />
                <x-body >
                    <div class="row g-2">
                        <div class="col-md-12">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a class="btn btn-outline-pdf" target='_blank'
                                    href="{{-- {{ route('report.sales.user', [$from, $to, $informations->id]) }} --}}">
                                    <i class="fa-sharp fa-solid fa-file-medical"></i>
                                    Descargar PDF
                                </a>
                            </div>
                        </div>
                        <div class="col-md-12">

                            <table class="tableDetail">
                                <thead>
                                <tbody>
                                    <tr>
                                        <td><strong>Nombre:</strong> {{ $informations->full_name }} </td>
                                        <td rowspan="4" align="center">
                                            <p style="font-size: 60px;font-weight=bold;">
                                                {{ $informations->id }}
                                            </p>
                                            <p>Codigo</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Rol :</strong>{{ $informations->roles->first()->name }} </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Ventas realizadas:</strong>{{ $informations->sales->count() }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Saldo total de ventas:</strong>
                                            {{ number_format($informations->sales->pluck('products')->collapse()->sum('pivot.precio') * 0.76, 2) }}
                                            Bs </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Desde:</strong> {{ $from->isoFormat('ddd, D \d\e MMM') . ' al ' . $to->isoFormat('ddd, D \d\e MMM \d\e\l Y') }}
                                            </td>
                                        </tr>
                                </tbody>
                            </table>

                        </div>
                        <div class="col-12">
                            <div class="mobile">
                                <table class="tableInfo">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Fecha</th>
                                            <th>subtotal</th>
                                            <th>Descuento</th>
                                            <th>Comision</th>
                                            <th>Transporte</th>
                                            <th>Importe total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($informations->sales as $info)
                                            <tr>
                                                <td>{{ $loop->iteration }} </td>
                                                <td>{{ $info->updated_at->format('d-m-Y') }} </td>
                                                <td>{{ $info->products->sum('pivot.precio')+$info->comision+$info->transporte }} Bs</td>
                                                <td>{{ $info->products->sum('pivot.precio') * 0.24 }}</td>
                                                <td>{{ $info->comision }}</td>
                                                <td>{{ $info->transporte }}</td>
                                                <td>{{ $info->products->sum('pivot.precio') * 0.76 }}</td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="6">Total</td>
                                            <td> {{ number_format($informations->sales->pluck('products')->collapse()->sum('pivot.precio') * 0.76, 2) }}
                                                Bs.</td>

                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </x-body>
            </div>
        </main>
    </div>



    @livewireScripts()

    <script src="{{ asset('build/assets/app-XM1nyk2I.js') }}"></script>

    <script src="{{ asset('js/action.js') }}"></script>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
</body>

</html>
