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
        font-size: 16px;
        border-collapse: collapse;

    }
    .tableDetail tr td{
        padding: 1px;
    }
    caption{
        font-size: 30px;
        text-align: left
    }


    .date{
        width: 100%;
        color: #000000;
        font-size: 16px;
        border-collapse: collapse;
    }

    .date thead th{
            background-color:rgb(162, 165, 170) ;
        color: rgb(0, 0, 0);
        padding: 8px 9px;
        font-size: 14px;
    }

    .date td{
        padding: 5px 5px;
    }
    .date tr
    {
        text-align: left;
    }
    .date tfoot td{
        background-color:rgb(181, 199, 235);
    }
    .img{
        position: relative;
        display: flex;
        top: -20px
    }
    .footer{
        position: relative;
        display: flex;
        bottom: -2%
    }
    </style>
    <div class="img">
        <img  src="{{public_path('IMG/log.png')}}" alt="" width="120" height="40">
        <hr border="2">
    </div>
            <table class="tableDetail">
                <caption>Datos del cliente</caption>
                <tr>
                    <td><strong>Fecha: </strong></td>
                    <td>{{ date('Y-m-d') }}</td>
                </tr>
                <tr>
                    <td><strong>Cliente:</strong></td>
                    <td>{{ $sale->customer->full_name }}</td>
                </tr>
                <tr>
                    <td><strong>Direccion:</strong></td>
                    <td>{{ $sale->direccion }} </td>
                </tr>
                <tr>
                    <td><strong>Encargado: </strong></td>
                    <td>{{ $sale->encargado }}</td>
                </tr>
            </table>
            <br>

            <p>Estimad@(s) Cliente(s): <br>
                Mediante la presente le saludamos a usted, nos es grato hacerle llegar a Ud. La cotización correspondiente a Viguetas  pretensadas UNICON S.A. y complemento de plastoformo, de acuerdo al siguiente detalle:
            </p>
            <table>
                <th>
                    <td><h4>ESPECIFICACIONES TECNICAS</h4></td>
                </th>
                <tr>
                    <td>Complemento:</td>
                    <td>{{ $sale->products->first()->caracteristicas }}</td>
                </tr>
                <tr>
                    <td>Carpeta de compresion</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td>Altura de la losa final</td>
                    <td>{{ $sale->observaciones+5 }}</td>
                </tr>
            </table>

            <div align="center">
                <strong>Tipo de obra: Loza / Departamento H = {{ $sale->espaciado+7}} cm</strong>
            </div>

            <table class="date">
                <caption>Datos de venta</caption>
                <thead>
                    <tr>
                        <th>Productos</th>
                        <th>Piezas</th>
                        <th>M.LASD</th>
                        <th>Area / m2</th>
                        <th>Precio</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Plastaformo</td>
                        <td>{{ $sale->products->where('categoria', 'Plastaformo')->sum('pivot.cantidad') }}</td>
                        <td rowspan="2">{{ $sale->areas->sum('ml') }} </td>
                        <td rowspan="2">{{ $sale->areas->sum('perimetro') }} </td>
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
                </tfoot>
                <tr style="background: rgb(155, 187, 89);color:rgb(58, 91, 238);font-size:21px">
                    <td colspan="4">Precio total con descuentos(Viguetas y complementos)</td>
                    <td >
                        {{ number_format($sale->products->sum('pivot.precio') * 0.76 + ($sale->comision + $sale->transporte), 2) }}
                        Bs.</td>
                </tr>
            </table>
            <p>*El material debera estar 100% cancelado para su entrega.    </p>
            <p>*La validez de la oferta es de QUINCE días.</p>
            <p>*Material puesto en obra.</p>
            <p><strong>*ASESORAMIENTO TÉCNICO GRATUITO </strong>en el momento que Ud.  requiera.</p>
            <br>
            <br>
            <p>UNICON S.A. tambien recomienda que el Armado y posterior vasiado de las lozas deberá efectuarse de acuerdo a las normas técnicas y especificaciones técnicas para productos UNICON S.A. <br>Sin otro particular y esperando poder brindarle pronto nuestros servicios nos es grato saludar a Uds. <br>Atentamente:</p>
            <div align="center" class="footer">
                <hr border="1" width="180px">
                {{$sale->user->person->nombre.' '.$sale->user->person->apellido}}
                <br><strong>Departamento Comercial</strong>
                <br><strong>Cel: </strong>{{$sale->user->person->telefono}}
                <br><strong>Email: </strong>{{$sale->user->email}}
            </div>

</body>
</html>
