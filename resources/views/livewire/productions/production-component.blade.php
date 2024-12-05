<div>
    <div class="row g-3">
        <div class="col-12">
            <x-header title='Control de producción' />
        </div>
        <div class="col-md-3">
            <span class="notification">Seleccione la fecha inicial de filtro</span>
            <div class="input-group">
                <span class="input-group-text">Fecha Inicial</span>
                <input class="form-control" type="date" wire:model.live='dateFrom'>
            </div>
        </div>
        <div class="col-md-3">

            <span class="notification">Seleccione la fecha final de filtro</span>
            <div class="input-group">
                <span class="input-group-text">Fecha Final</span>
                <input class="form-control" type="date" wire:model.live='dateTo'>
            </div>
        </div>
        <div class="col-md-6">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#theModal">
                    <i class="fa-sharp fa-solid fa-file-medical"></i>
                    Nueva produccion
                </button>
            </div>
        </div>
        @forelse ($productions as $production)
            <div class="col-md-4">
                <div class="cardmain2 {{ $production->estado == 'Revision' ? 'active' : '' }} ">
                    <div class="resolution">
                        <div class="row g-2">
                            <div class="col-12">
                                <table class="prueba">
                                    <tr>
                                        <td>
                                            <div class="align">
                                                Produc. {{ $production->id }}
                                                <ion-icon
                                                    class="{{ $production->estado == 'Revision' ? 'icond' : 'icong' }} fas fa-list-alt">
                                                </ion-icon>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-12">
                                <table class="prueba">
                                    <tbody>
                                        <tr>
                                            <td><strong>Encargado:</strong>
                                                {{ $production->user->full_name }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total bloques:</strong> {{ $production->cantidad }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Ayudantes:</strong> {{ $production->users->count() }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Fecha:</strong> {{ $production->created_at }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table class="tableDetail">
                                                    <thead>
                                                        <tr>
                                                            <th>Producto</th>
                                                            <th>cantidad</th>
                                                            <th>bajas</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($production->products as $product)
                                                            <tr>
                                                                <td>{{ $product->nombre }}</td>
                                                                <td>{{ $product->pivot->cantidad }} </td>
                                                                <td>{{ $product->pivot->bajas }} </td>
                                                            </tr>
                                                        @endforeach

                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        @if ($production->estado != 'Concluido')
                                            <tr>
                                                @can('Administrar produccion')
                                                    <td>
                                                        <div class="d-grid gap-2">
                                                            <button class="btn btn-blue"
                                                                onclick="Fase('{{ $production->id }}'
                                ,'¿Desea concluir la produccions?','La produccion finalizo')">
                                                                <i class="fas fa-sign-out-alt"></i> Aprobar</button>
                                                        </div>
                                                    </td>
                                                @endcan
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>

                            </div>
                            @if ($production->estado != 'Concluido')
                                <div class="col-md-6">
                                    <div class="d-grid gap-2">
                                        <a class="btn btn-outline-pdf" target='_blank' href="">
                                            <i class="fa-sharp fa-solid fa-file-medical"></i>
                                            Descargar PDF
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-6">

                                    <div class="d-grid gap-2">
                                        <button class="btn btn-purple" wire:click="edit({{ $production->id }})"
                                            data-bs-toggle="modal" data-bs-target="#theModal"><i
                                                class="fas fa-edit"></i>
                                            Editar</button>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-danger" onclick="Confirm('{{ $production->id }}')">
                                            <i class="fas fa-trash"></i> Eliminar</button>
                                    </div>
                                </div>
                            @else
                                <div class="col-md-12">
                                    <div class="d-grid gap-2">
                                        <a class="btn btn-outline-pdf" target='_blank' href="">
                                            <i class="fa-sharp fa-solid fa-file-medical"></i>
                                            Descargar PDF
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        @empty
            <div class="col-md-12">

                <div class="cardmain2">
                    <div class="row">
                        <div class="col-12 p-2" align="center">
                            <i class="far fa-frown fa-shake fs-6"></i>
                            <h2>No se encontro ningun registro...</h2>
                        </div>
                    </div>
                </div>
            </div>
        @endforelse

        {{ $productions->links() }}
    </div>
    @include('livewire.productions.form')
</div>
