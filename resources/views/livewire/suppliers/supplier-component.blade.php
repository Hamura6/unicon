<div>
    {{-- Do your work, then step back. --}}
    <div class="row">
        <x-header title='Control de proveedores' />
        <x-body>
            <div class="row g-2">
                @can('Crear proveedor')
                    <div class="col-md-12">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#theModal">
                                <i class="fa-sharp fa-solid fa-file-medical"></i>
                                Nuevo proveedores
                            </button>
                        </div>
                    </div>
                @endcan
                <div class="col-md-7 offset-md-2 mb-5">
                    <x-search />
                </div>
                <div class="col-12">
                    <div class="mobile">
                        <table class="tableDate">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Nº de CI</th>
                                    <th>Telefono</th>
                                    <th>Empresa</th>
                                    <th>Compras</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($suppliers as $supplier)
                                    <tr>
                                        <td>{{ $loop->iteration }} </td>
                                        <td>{{ $supplier->nombre }}</td>
                                        <td>{{ $supplier->ci }}</td>
                                        <td>{{ $supplier->telefono }}</td>
                                        <td>{{ $supplier->empresa }}</td>
                                        <td></td>
                                        <td align="center">
                                            <span
                                                class="{{ $supplier->estado == 'Activo' ? 'status-on' : 'status-off' }} ">{{ $supplier->estado }}</span>
                                            <div class="form-switch">
                                                @can('Editar proveedor')
                                                    
                                                <input class="form-check-input" type="checkbox"
                                                {{ $supplier->estado == 'Activo' ? 'checked' : '' }}
                                                wire:click="changeStatus({{ $supplier->id }}  )">
                                                @endcan
                                            </div>
                                        </td>
                                        <td align="center">
                                            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                                @can('Eliminar proveedor')
                                                    <button class="btn btn-danger"
                                                        onclick="Confirm('{{ $supplier->person_id }}')"><i
                                                            class="fas fa-trash-alt"></i> Eliminar</button>
                                                @endcan
                                                @can('Editar proveedor')
                                                    <button class="btn btn-purple" wire:click="edit({{ $supplier->id }})"
                                                        data-bs-toggle="modal" data-bs-target="#theModal"><i
                                                            class="fas fa-edit"></i>
                                                        Editar</button>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" align="center"><i class="far fa-frown fa-shake"></i> No se
                                            encontro ningun registro...</td>
                                    </tr>
                                @endforelse ($suppliers as $supplier )
                            </tbody>
                        </table>
                    </div>

                    {{ $suppliers->links() }}
                </div>
            </div>
        </x-body>
    </div>
    @include('livewire.Suppliers.form')
</div>
