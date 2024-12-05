<div>
    <div class="row g-3">
        <div class="col-12">
            <x-header title='Reporte de ventas' />
        </div>
        <div class="col-md-12">
            <x-body subtitle='Filtros'>
                <div class="d-flex align-items-start">
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text">Fecha Inicial</span>
                            <input class="form-control" type="date" wire:model.live='dateFrom'>
                        </div>
                        <span class="notification">Seleccione la fecha inicial de filtro</span>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text">Fecha Final</span>
                            <input class="form-control" type="date" wire:model.live='dateTo'>
                        </div>
                        <span class="notification">Seleccione la fecha final de filtro</span>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text">Tipo de reporte</span>
                            <select name="" id="" class="form-select" wire:model.live='consult'>
                                <option value="0">Elegir</option>
                                <option value="week">Semanal</option>
                                <option value="month">Mensual</option>
                                <option value="quarterly">Trimestral</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button class="btn btn-outline-warning" wire:click='resetReport()'><i
                                    class="fa-sharp fa-solid fa-broom"></i> Restablecer filtros</button>
                        </div>
                    </div>
                </div>
            </x-body>
        </div>

        <x-body>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a class="btn btn-outline-pdf" target='_blank'
                    href="{{ route('report.sales', [$this->dateFrom, $this->dateTo]) }}">
                    <i class="fa-sharp fa-solid fa-file-medical" style="font-size: 20px"></i>
                    Descargar PDF
                </a>
                <a
                    href="{{ route('report.excel.sale', [$this->dateFrom, $this->dateTo]) }} "class="btn btn-outline-excel">
                    <i class="fa-solid fa-file-excel" style="font-size: 20px"></i>
                    Descargar Excel</a>
            </div>
            <br>
            <table class="tableDetail" style="margin-bottom: 5px">
                <tr>
                    <td colspan="2"><strong>Fecha:</strong>
                        {{ $dateFrom->isoFormat('ddd, D \d\e MMM') . ' al ' . $dateTo->isoFormat('ddd, D \d\e MMM \d\e\l Y') }}
                    </td>
                </tr>

            </table>
            <div class="mobile">
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
                            <th>Detalle</th>

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
                                <td>
                                    <div class="d-grid gap-2">
                                    <a href="{{route('sale.report.user',[$user->id,$this->dateFrom,$this->dateTo])}}"
                                    class="btn btn-success">
                                    <i class="fas fa-eye"></i></a> 
                                    </div>
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
                            <td colspan="2">
                                {{ number_format($users->sum('full_price') * 0.76 +$users->pluck('sales')->collapse()->sum('overol') *65,2) }}
                                Bs</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </x-body>
    </div>
</div>
