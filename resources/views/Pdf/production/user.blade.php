<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <style>
        .tableDetail {
            width: 100%;
            color: var(--blue);
            font-size: 12px;
            border-collapse: collapse;

        }

        .tableDetail tr th {
            text-align: left;
            border-style: solid;
            border-width: 1px 1px;
            padding: 7px;
        }

        .tableDetail tr td {
            border-style: solid;
            padding: 7px;
            border-width: 1px;
        }

        .img {
            position: relative;
            display: flex;
            top: -40px
        }
    </style>
    <div class="img">
        <img src="{{ public_path('IMG/log.png') }}" alt="" width="120" height="40">
        <hr border="2">
    </div>
    @foreach ($users as $user)
    <table class="tableDetail">
        <thead>
        <tbody>
            <tr>
                <td><strong>Nombre: </strong>{{ $user->full_name }}</td>
                <td rowspan="4" align="center" style="padding: 0px;">
                    <strong style="font-size: 60px">{{ $user->id }}</strong>
                    <br>codigo
                </td>
            </tr>
            <tr>
                <td><strong>Rol: </strong>{{ $user->roles->first()->name }}</td>
            </tr>
            <tr>
                <td><strong>Participación: </strong>{{ $user->productions->count() }}</td>
            </tr>
            <tr>
                <td><strong>Gestión: </strong>{{ date('Y') }}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <table border="1">
        @foreach ($user->productions->chunk(2) as $productions)
            <tr>
                @foreach ($productions as $production)
                    <td>
                        <table class="tableDetail">
                            <tr>
                                <td colspan="5">
                                    <div class="align">
                                        Produc. {{ $production->id }}
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <strong>Material: </strong>{{ $production->material->nombre }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <strong>Cantidad de material: </strong>{{ $production->cantidad }}
                                </td>
                            </tr>
                            <tr><th colspan="5">Productos</th></tr>
                            <tr>
                                <th>Nº</th>
                                <th colspan="2">Nombre</th>
                                <th colspan="2">cantidad</th>
                            </tr>
                            @forelse ($production->products as $item )
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td colspan="2">{{ $item->nombre }}</td>
                                <td colspan="2">{{ $item->pivot->cantidad }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" align="center">No se encontro registros...</td>
                            </tr>
                            @endforelse
                            <tr>
                                <td colspan="3"><strong>Total:</strong></td>
                                <td colspan="2"> {{ $production->products->sum('pivot.cantidad') }}</td>
                            </tr>
                            <tr><th colspan="5">Ayudantes</th></tr>
                            <tr>
                                <th>Nº</th>
                                <th>Nombre</th>
                                <th>Hora de entrada</th>
                                <th>Hora de salida</th>
                                <th>Total</th>
                            </tr>
                            @forelse ($production->users as $item )
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->full_name }}</td>
                                <td>{{ $item->pivot->entrada }}</td>
                                <td>{{ $item->pivot->salida }}</td>
                                <td>{{ Carbon\Carbon::parse('00:00:00')->addSeconds($item->pivot->hour)->format('H:i:s') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" align="center">No se encontro registros...</td>
                            </tr>
                            @endforelse
                            
                            <tr>
                                <td colspan="5"><strong>Ayudantes:</strong> {{ $production->users->count() }}</td>
                            </tr>
                        </table>
                    </td>
                @endforeach
            </tr>
        @endforeach
    </table>
@endforeach



    {{--     <div class="grid-container">
        @forelse ($user->bloques->chunk(2) as $productions)
            @forelse ($chunkBloques as $bloque )
            <table class="tableDetail">
                <tr>
                    <td colspan="5">
                        <div class="align">
                            Produc. {{ $bloque->id }}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <strong>Cantidad de bloques: </strong>
                        {{ $bloque->quantity }}
                    </td>
                </tr>
                <tr>
                    <th>Nº</th>
                    <th>Nombre </th>
                    <th>Hora de entrada</th>
                    <th>Hora de salida</th>
                    <th>Total</th>
                </tr>
                @forelse ($bloque->users as $item)
                    <tr>
                        <td>{{ $loop->iteration }} </td>
                        <td>{{ $item->full_name }}</td>
                        <td>{{ $item->pivot->start }}</td>
                        <td>{{ $item->pivot->end }}</td>
                        <td>{{ Carbon\Carbon::parse('00:00:00')->addSeconds($item->pivot->hour)->format('H:i:s') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" align="center">
                            <strong> No se encontro
                                ningun
                                registro...</strong></td>
                    </tr>
                @endforelse ()
                <tr>
                    <td colspan="5"><strong>Ayudantes:</strong> {{ $bloque->users->count() }}
                    </td>
                </tr>
            </table>
            <br>
            @empty

            @endforelse
        @empty
            <div align="center">
                <strong> No se encontro ningun registro...</strong>
            </div>
        @endforelse ($bloques as $bloque)
    </div> --}}

</body>

</html>
