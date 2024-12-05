<div>
    <div class="row g-3">
        <x-header title='Gestion de clientes' />
        <x-body>
            <div class="row g-2">
                @can('Crear cliente')
                    <div class="col-md-12">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#theModal">
                                <i class="fa-sharp fa-solid fa-file-medical"></i>
                                Nuevo cliente
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
                                    <th>Nombre</th>
                                    <th>Nº de CI</th>
                                    <th>Telefono</th>
                                    <th>Correo electornico</th>
                                    <th>Estado</th>
                                    <th>Acciones </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($customers as $customer)
                                    <tr>
                                        <td>{{ $customer->nombre . ' ' . $customer->apellido }}</td>
                                        <td>{{ $customer->ci }}</td>
                                        <td>{{ $customer->telefono }}</td>
                                        <td>{{ $customer->email }}</td>
                                        <td align="center">
                                            <span
                                                class="{{ $customer->estado == 'Activo' ? 'status-on' : 'status-off' }}">{{ $customer->estado }}</span>
                                            @can('Editar cliente')
                                                <div class="form-switch">
                                                    <input class="form-check-input" type="checkbox"
                                                        {{ $customer->estado == 'Activo' ? 'checked' : '' }}
                                                        wire:click="changeStatus({{ $customer->id }})">
                                                </div>
                                            @endcan
                                        </td>
                                        <td align="center">
                                            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                                @can('Eliminar cliente')
                                                    <button class="btn btn-danger"
                                                        onclick="Confirm('{{ $customer->person_id }}')"><i
                                                            class="fas fa-trash-alt"></i> Eliminar</button>
                                                @endcan
                                                @can('Editar cliente')
                                                    <button class="btn btn-purple"
                                                        wire:click="edit({{ $customer->person_id }})" data-bs-toggle="modal"
                                                        data-bs-target="#theModal"><i class="fas fa-edit"></i>
                                                        Editar</button>
                                                @endcan 
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" align="center"><i class="far fa-frown fa-shake"></i> No se
                                            encontro ningun registro...</td>
                                    </tr>
                                @endforelse ($customers as $customer)
                            </tbody>
                        </table>
                    </div>

                    {{ $customers->links() }}
                </div>
            </div>
        </x-body>
    </div>
    @include('livewire.Customers.form')
</div>
