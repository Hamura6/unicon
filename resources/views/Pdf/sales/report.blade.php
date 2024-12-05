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
               .tableDetail{
    width: 100%;
    color: var(--blue);
    font-size: 16px;
    border-collapse: collapse;

}
.tableDetail tr th{
    text-align: left;
    border-style: solid;
    border-width: 1px 1px;
    padding: 5px;
}
.tableDetail tr td{
    border-style: solid;
    padding: 5px;
    border-width: 1px;
}

    </style>
    <div class="img">
        <img  src="{{public_path('IMG/log.png')}}" alt="" width="120" height="40">
        <hr border="2">
    </div>
    <h2 align="center">Reporte de ventas</h2>
    <table class="tableDetail">
        <tbody>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Nro de ventas</th>
                <th>Subtotal</th>
                <th>Comision</th>
                <th>Descuento</th>
                <th>Transporte </th>
                <th>Total</th>

            </tr>
            @forelse ($users as  $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->full_name }}</td>
                    <td>{{ $user->sales->count() }} </td>
                    <td>{{ $user->full_price+$user->sales->sum('comision')+$user->sales->sum('transporte') }} </td>
                    <td>{{ $user->sales->sum('comision') }} </td>
                    <td>{{ number_format($user->sales->pluck('products')->collapse()->sum('pivot.precio') * 0.24,2) }}
                        Bs </td>
                    <td>{{ number_format($user->sales->sum('transporte'),2) }}
                        Bs </td>
                    <td>{{ number_format($user->sales->pluck('products')->collapse()->sum('pivot.precio') * 0.76,2) }}
                            Bs
                        </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" align="center"><strong> <i class="far fa-frown fa-shake"></i>
                            No se encontro ningun registro...</strong></td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="7">Total</td>
                <td >
                    {{ number_format($users->sum('full_price') * 0.76 +$users->pluck('sales')->collapse()->sum('overol') *65,2) }}
                    Bs</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
