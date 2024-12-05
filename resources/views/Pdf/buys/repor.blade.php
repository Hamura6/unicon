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
            font-size: 14px;
            border-collapse: collapse;

        }

        .tableDetail tr th {
            text-align: left;
            border-style: solid;
            border-width: 1px 1px;
            padding: 4px;
        }

        .tableDetail tr td {
            border-style: solid;
            padding: 3px;
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
    <h2 align="center">Reporte de compra de materia prima</h2>
    <table class="tableDetail">
        <thead>
            <tr>
                <th>#</th>
                <th>Fecha</th>
                <th>Nombre de usuario</th>
                <th>Nombre proveedor</th>
                <th>Material</th>
                <th>Cantidad</th>
                <th>Saldo total</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($buys as $buy)
                <tr>
                    <td>{{ $loop->iteration }} </td>
                    <td>{{ $buy->updated_at->format('d-m-Y') }} </td>
                    <td>{{ $buy->user->full_name }} </td>
                    <td>{{ $buy->supplier->person->apellido.' '.$buy->supplier->person->nombre }} </td>
                    <td>{{ $buy->material->nombre }} </td>
                    <td>{{ $buy->cantidad }} Kg. </td>
                    <td>{{ $buy->precio }} Bs </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" align="center">
                        <i class="far fa-frown fa-shake"></i> No se encontro ningun registro...
                    </td>
                </tr>
            @endforelse ()

        </tbody>
        <tfoot>
            <tr>
                <td colspan="5">Total</td>
                <td>{{ $buys->sum('cantidad') }} Kg. </td>
                <td>{{ $buys->sum('precio') }} Bs</td>
            </tr>
        </tfoot>
    </table>
</body>

</html>
