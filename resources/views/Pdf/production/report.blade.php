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
    font-size: 12px;
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
    padding: 7px;
    border-width: 1px;
}
.img{
        position: relative;
        display: flex;
        top: -40px
    }
    </style>
<div class="img">
    <img  src="{{public_path('IMG/log.png')}}" alt="" width="120" height="40">
    <hr border="2">
</div>
<h2 align="center">Reporte de Produccion</h2>
<table class="tableDetail">
    <thead>
        <tr>
            <th>#</th>
            <th>Fecha</th>
            <th>Nombre</th>
            <th>Ayudantes</th>
            <th>Productos producidos</th>
            <th>Cantidad de material</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($productions as $production)
            <tr>
                <td>{{ $loop->iteration }} </td>
                <td>{{ $production->updated_at->format('d-m-Y') }} </td>
                <td>{{ $production->user->full_name }} </td>
                <td>
                    <ul style="list-style: none">
                        @forelse ( $production->users as $user )
                        
                        <li>{{ $user->full_name }} - {{$user->pivot->hour}}
                        </li>
                        @empty
                            <li>No se encontro registros...</li>
                        @endforelse 
                    </ul>

                </td>
                <td>
                    <ul style="list-style: none">
                        @foreach ($production->products as $product)
                            <li>{{ $product->nombre }}={{ $product->pivot->cantidad }}
                            </li>
                        @endforeach
                    </ul>

                </td>
                <td>{{ $production->cantidad }} Kg.</td>
            </tr>
        @empty
            <tr>
                <td colspan="7" align="center">
                    <i class="far fa-frown fa-shake"></i> No se encontro ningun registro...
                </td>
            </tr>
        @endforelse

    </tbody>
    <tfoot>
        <tr>
            <td colspan="5">Total</td>
            <td>{{ $productions->sum('cantidad') }} Kg. </td>
        </tr>
    </tfoot>
</table>
</body>
</html>
