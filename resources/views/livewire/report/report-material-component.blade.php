<div>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
    <div class="row g-3">
        <x-header title="Reporte Compra" />
        <div class="col-md-4">
            <x-body subtitle='Filtros'>
                <div class="d-flex align-items-start">

                </div>
                <div class="row g-3">
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-text">Fecha Inicial</span>
                            <input class="form-control" type="date" wire:model='dateFrom'>
                        </div>
                        <span class="notification">Seleccione la fecha inicial de filtro</span>
                    </div>
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-text">Fecha Final</span>
                            <input class="form-control" type="date" wire:model='dateTo'>
                        </div>
                        <span class="notification">Seleccione la fecha final de filtro</span>
                    </div>
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-text">Tipo de reporte</span>
                            <select name="" id="" class="form-select" wire:model='consult'>
                                <option value="0">Elegir</option>
                                <option value="week">Semanal</option>
                                <option value="month">Mensual</option>
                                <option value="quarterly">Trimestral</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="d-grid gap-2">
                            <button class="btn btn-blue" wire:click="report()"><i class="fa-sharp fa-solid fa-clipboard-question"></i>
                                Consultar</button>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-warning" wire:click='resetReport()'><i
                                    class="fa-sharp fa-solid fa-broom"></i> Restablecer filtros</button>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="d-grid gap-2">
                            <a class="btn btn-outline-pdf" target="_back" type="button" href="{{route('report.buys',[$this->dateFrom,$this->dateTo])}}" >
                                <i class="fa-sharp fa-solid fa-file-medical"></i>
                                Descargar PDF
                            </a>
                        </div>
                    </div>
                </div>
            </x-body>
        </div>
        <div class="col-md-8">
            <x-body subtitle="Compra de materia prima">

                <div class="mobile">
                    <table class="table">
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
                            @forelse ( $buys as $buy)
                            <tr>
                                <td>{{ $loop->iteration }} </td>
                                <td>{{$buy->updated_at->format('d-m-Y')}} </td>
                                <td>{{ $buy->user->full_name }} </td>
                                <td>{{ $buy->supplier->person->nombre.' '.$buy->supplier->person->apellido }} </td>
                                <td>{{ $buy->material->nombre }} </td>
                                <td>{{ $buy->cantidad }} Kg. </td>
                                <td>{{ $buy->precio}} Bs </td>
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
                                <td>{{$buys->sum('cantidad')}} Kg. </td>
                                <td>{{$buys->sum('precio')}} Bs</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

            </x-body>
        </div>
    </div>
</div>
