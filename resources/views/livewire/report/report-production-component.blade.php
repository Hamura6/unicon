<div class="row g-3">
    <div class="col-12">
        <x-header title='Reporte de produccion' />
    </div>
    <div class="col-md-12">
        <x-body subtitle='Filtros'>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text">Fecha Inicial</span>
                        <input class="form-control" type="date" wire:model.defer='dateFrom'>
                    </div>
                    <span class="notification">Seleccione la fecha inicial de filtro</span>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text">Fecha Final</span>
                        <input class="form-control" type="date" wire:model.defer='dateTo'>
                    </div>
                    <span class="notification">Seleccione la fecha final de filtro</span>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text">Tipo de reporte</span>
                        <select name="" id="" class="form-select" wire:model.defer='consult'>
                            <option value="0">Elegir</option>
                            <option value="week">Semanal</option>
                            <option value="month">Mensual</option>
                            <option value="quarterly">Trimestral</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-blue" wire:click='report()'><i
                                class="fa-sharp fa-solid fa-clipboard-question"></i> Consultar</button>

                        {{-- <a class="btn btn-outline-primary" target='_blank'
                            href="{{ route('sales.report', [$this->dateFrom, $this->dateTo]) }}">
                            <i class="fa-sharp fa-solid fa-file-medical"></i>
                            Imprimir
                        </a> --}}
                        <button class="btn btn-outline-warning" wire:click='resetReport()'><i
                                class="fa-sharp fa-solid fa-broom"></i> Restablecer filtros</button>
                    </div>
                </div>
            </div>
        </x-body>
    </div>
    <x-body>
        <div class="col-md-12">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a class="btn btn-outline-pdf" target='_blank'
                    href="{{ route('report.productions', [$this->dateFrom, $this->dateTo]) }}">
                    <i class="fa-sharp fa-solid fa-file-pdf" style="font-size: 20px"></i>
                    Descargar PDF
                </a>
                <a href="{{ route('report.excel.productions', [$this->dateFrom, $this->dateTo]) }} "class="btn btn-outline-excel">
                    <i class="fa-solid fa-file-excel" style="font-size: 20px"></i>
                    Descargar Excel</a>
                <div class="d-grid gap-2">
                    <a href="{{ route('report.productions.user', [$this->dateFrom, $this->dateTo]) }}"
                        class="btn btn-danger">
                        <i class="fa-sharp fa-solid fa-file-pdf" style="font-size: 20px"></i>
                        Descarga detallada</a>
                </div>
            </div>
            <div class="mobile">
                <table class="tableDetail">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Fecha</th>
                            <th>Nombre</th>
                            <th>Ayudantes</th>
                            <th>Productos producidos</th>
                            <th>Cantidad de materiales</th>
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
                                        @foreach ($production->users as $user)
                                            <li>{{ $user->full_name }} - {{ $user->pivot->hour }}
                                            </li>
                                        @endforeach
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
            </div>
        </div>
    </x-body>
</div>
