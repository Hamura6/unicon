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
                <x-header title='Venta Nro. {{ $sale->id }}' />
                <x-body subtitle='Proforma de presupuesto'>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a class="btn btn-outline-pdf" target="_black"
                                    href="{{ route('sale.budget', $sale->id) }}">
                                    <i class="fas fa-file-pdf" style="font-size: 20px"></i>
                                    Descargar PDF
                                </a>
                               


                            </div>
                        </div>
                        <div class="col-12">
                            @if (session('error'))
                                <div class="alert alert-danger" role="alert">

                                    {!! session('error') !!}
                                </div>
                            @endif
                            <h2 class="mb-3">Datos del cliente</h2>
                            <table style="font-size: 18px">
                                <tr>
                                    <td><strong>Fecha: </strong>{{ date('Y-m-d') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Nombre:</strong>{{ $sale->customer->person->nombre }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Encargado:</strong>{{ $sale->encargado }} </td>
                                </tr>
                                <tr>
                                    <td><strong>Dirección: </strong>{{ $sale->direccion }} </td>
                                </tr>
                                <tr>
                                    <td><strong>Observación: </strong>H{{ $sale->observaciones }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-12">
                            <h2>Datos de venta</h2>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Productos</th>
                                        <th>Piezas</th>
                                        <th>M.LASD</th>
                                        <th>Aare / m2</th>
                                        <th>Precio</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Plastaformo</td>
                                        <td>{{ $sale->products->where('categoria', 'Plastaformo')->sum('pivot.cantidad') }}</td>
                                        <td rowspan="2">{{ $sale->areas->sum('perimetro') }} </td>
                                        <td rowspan="2">{{ $sale->areas->sum('espacio') }} </td>
                                        <td>{{ $sale->products->where('categoria', 'Plastaformo')->sum('pivot.precio') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Viguetas</td>
                                        @if ($sale->products->where('categoria', 'Vigueta')->sum('pivot.cantidad'))
                                            <td>{{ $sale->areas->sum('espacio') }}</td>
                                        @else
                                            <td>0</td>
                                        @endif
                                        <td>{{ $sale->products->where('categoria', 'Vigueta')->sum('pivot.precio') }} Bs.</td>
                                    </tr>

                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4">Precio</td>
                                        <td>{{ $sale->products->sum('pivot.precio') }} Bs.</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">Precio con descuento</td>
                                        <td style="color: white">
                                            {{ number_format($sale->products->sum('pivot.precio') * 0.76 + ($sale->comision + $sale->transporte), 2) }}
                                            Bs.</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </x-body>
                <x-body subtitle='Nota de remision'>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <table width='100%'>
                                <tr>
                                    <td>CLIENTE</td>
                                </tr>
                                <tr>
                                    <td><strong>Nombre: </strong>{{ $sale->customer->person->nombre }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Direccion: </strong>{{ $sale->direccion }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Telefono: </strong>{{ $sale->customer->person->telefono }}</td>
                                </tr>
                            </table>
                        </div>
                        @if ($sale->transporte)
                            <div class="col-md-6">
        
                                <table width='100%'>
                                    <tr>
                                        <td>TRANSPORTE</td>
                                    </tr>
                                    <tr>
                                    <tr>
                                        <td><strong>Costo: </strong>{{ $sale->trasnporte }}</td>
                                    </tr>
                                </table>
                            </div>
                        @endif
                    </div>
        
        
                    <div class="mobile">
                        <table class="tableDetail">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Cantidad</th>
                                    <th>UM</th>
                                    <th>Codigo de producto</th>
                                    <th>Descripcion</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sale->products->where('categoria', 'Plastaformo') as $product)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $product->pivot->cantidad }} </td>
                                        <td>UN</td>
                                        <td>{{ $product->id }}</td>
                                        <td>{{ $product->caracteristicas }}</td>
                                    </tr>
                                @endforeach
                                @if ($sale->products->contains('categoria', 'Vigueta'))
                                    @foreach ($sale->areas as $area)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $area->espacio }}</td>
                                            <td>UN</td>
                                            <td>{{ $sale->products->where('pivot.cantidad', $area->espacio)->first() }} </td>
                                            <td>{{ $sale->products->where('categoria', 'Vigueta')->first()->nombre . ' - ' . $area->altura }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
        
                    <br>
                    {{--             <h2 class="mb-3">Plastoformo</h2>
                    <table class="tableDetail">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Plastoformo</th>
                                <th>Piezas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sale->products->where('category_id', 1) as $product)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->pivot->quantity }} </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table> --}}
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
