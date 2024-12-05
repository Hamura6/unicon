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
                    <x-header title="Panel de control" />
                    <div class="col-md-4">
                        <div class="cardmain blue">
                            <div class="align">
                                <span class="fa-sharp fa-solid fa-cart-shopping"></span>
                                Saldo de Ventas
                            </div>
                            <div class="row">
                                <div class="col-8">
                                    <br>
                                    <div class="responsive">
                                        <table>
                                            <tr>
                                                <td><strong>Total: </strong></td>
                                                <td>{{ number_format($sales->where('estado','Ejecutado')->pluck('products')->collapse()->sum('pivot.precio') *0.76,2) }}
                                                    Bs</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Ventas: </strong> </td>
                                                <td>{{ $sales->where('estado', 'Ejecutado')->count() }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong class="status-off">Espera</strong></td>
                                                <td>{{ $sales->where('estado', 'Pendiente')->count() }}
                                                </td>
                                            </tr>
                                        </table>
                                    </div>

                                </div>
                                <div class="col-4">
                                    <div id="chart1"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="cardmain danger">
                            <div class="align">
                                <span class="fa-sharp fa-solid fa-bag-shopping"></span>
                                Saldo de compras
                            </div>
                            <br>
                            <div class="responsive">
                                <table width="100%">
                                    <tr>
                                        <td><strong> Total: </strong> </td>
                                        <td> {{ number_format($buys->sum('precio')) }} Bs</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Compras: </strong> </td>
                                        <td> {{ $buys->count() }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cardmain success">
                            <div class="align">

                                <span class="fa-sharp fa-solid fa-industry"></span>
                                Produccion
                            </div>
                            <br>
                            <div class="responsive">
                                <table width="100%">
                                    <tr>
                                        <td><strong>Cantidad: </strong> </td>
                                        <td>{{ $productions->pluck('products')->collapse()->sum('pivot.cantidad') }}
                                            UNI. </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Producciones: </strong> </td>
                                        <td> {{ $productions->count() }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cardmain warning">
                            <div class="align">
                                <span class="fas fa-users"></span>
                                Usuarios
                            </div>
                            <br>
                            <div class="responsive">
                                <table width="100%">
                                    <tr>
                                        <td><strong class="status-on">Activos:</strong> </td>
                                        <td> {{ $users->where('estado', 'Activo')->count() }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong class="status-off">Bloqueados:</strong> </td>
                                        <td> {{ $users->where('estado', 'Bloqueado')->count() }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total: </strong> </td>
                                        <td> {{ $users->count() }}</td>
                                    </tr>
                                </table>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cardmain purple">
                            <div class="align">
                                <span class="fa-sharp fa-solid fa-address-book"></span>
                                Clientes
                            </div>
                            <br>
                            <div class="responsive">
                                <table width="100%">
                                    <tr>
                                        <td><strong class="status-on">Activos:</strong> </td>
                                        <td> {{ $customers->where('estado', 'Activo')->count() }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong class="status-off">Bloqueados:</strong> </td>
                                        <td> {{ $customers->where('estado', 'Bloqueado')->count() }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total: </strong> </td>
                                        <td> {{ $customers->count() }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cardmain secondary">
                            <div class="align">
                                <span class="fa-sharp fa-solid fa-address-card"></span>
                                Proveedores
                            </div>
                            <br>
                            <div class="responsive">
                                <table width="100%">
                                    <tr>
                                        <td><strong class="status-on">Activos:</strong> </td>
                                        <td> {{ $suppliers->where('estado', 'Activo')->count() }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong class="status-off">Bloqueados:</strong> </td>
                                        <td> {{ $suppliers->where('estado', 'Bloqueado')->count() }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total: </strong> </td>
                                        <td> {{ $suppliers->count() }}</td>
                                    </tr>
                                </table>
                            </div>

                        </div>
                    </div>


                    <div class="col-md-6" >
                        <x-body subtitle="TOP 3 de productos mas vendidos">
                            <div id="chart3"></div>
                        </x-body>
                    </div>
                    <div class="col-md-6" >
                        <x-body subtitle="Ventas de usuario">
                            <div>
                                <div id="chart2"></div>
                            </div>
                        </x-body>
                    </div>
                    <div class="col-md-12" wire:loading.remove>
                        <x-body subtitle="Produccion de productos">
                            <div id="chart"></div>
                        </x-body>
                    </div>
                </div>
                {{-- {{dd($sales->pluck('user.name')->diff())}} --}}

                <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
                <script>
                    var options = {
                        chart: {
                            height: 100,
                            type: 'radialBar',
                        },
                        series: [@json(number_format(
                                ($sales->where('estado', '!=', 'Pendiente')->count() * 100) / ($sales->count() ? $sales->count() : 1)))],
                        labels: [''],

                    }
                    var chart1 = new ApexCharts(document.querySelector("#chart1"), options);

                    chart1.render();


                    var options = {
                        chart: {
                            type: 'line'
                        },
                        series: [{
                            name: 'sales',
                            data: @json($salesUsers->pluck('price_full'))
                        }],
                        xaxis: {
                            categories: @json($salesUsers->pluck('CNombre'))
                        }
                    }

                    var chart2 = new ApexCharts(document.querySelector("#chart2"), options);

                    chart2.render();









                    var options = {


                        chart: {
                            height: 280,
                            type: "area"
                        },
                        dataLabels: {
                            enabled: false
                        },
                        series: [{
                            name: "Series 1",
                            data: @json($productionsC->pluck('total'))
                        }],


                        xaxis: {
                            categories: @json($productionsC->pluck('nombre'))
                        }
                    }

                    var chart = new ApexCharts(document.querySelector("#chart"), options);

                    chart.render();



                    var options = {
                        plotOptions: {
                            bar: {
                                distributed: true
                            }
                        },
                        chart: {
                            type: 'bar'
                        },
                        series: [{
                            name: 'sales',
                            data: @json($products1->pluck('total'))
                        }],
                        xaxis: {
                            categories: @json($products1->pluck('nombre'))
                        }
                    }

                    var chart3 = new ApexCharts(document.querySelector("#chart3"), options);

                    chart3.render();
                </script>
 


        </main>
    </div>



    {{-- @vite(['resources/js/app.js']) --}}
    <script src="{{ asset('build/assets/app-XM1nyk2I.js') }}"></script>
    <script src="{{ asset('js/action.js') }}"></script>
    @yield('scripts')
</body>

</html>
