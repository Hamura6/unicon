<div>
    <div class="row g-2">
        <x-header title='Control  de usuarios' />
        <x-body>
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text">Seleccione un rol</span>
                        <select name="" id="" class="form-select" wire:model.live="selector">
                            <option value="">Elegir</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }} </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-8">
                    @can('Crear usuario')
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                data-bs-target="#theModal">
                                <i class="fa-sharp fa-solid fa-file-medical"></i>
                                Nuevo Usuario
                            </button>
                        </div>
                    @endcan
                </div>
                <div class="col-md-7 offset-md-2 mb-5">
                    <x-search />
                </div>
                <div class="col-12">
                    <table class="table-data table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Imagen</th>
                                <th scope="col">Nombre y Apellido</th>
                                <th scope="col">Nro de CI</th>
                                <th scope="col">Numero de Celular</th>
                                <th scope="col">Correo electronico</th>
                                <th scope="col">Rol</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Operaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }} </th>
                                    <th><img src="{{ $user->imagen }}" width="90" height="72" id="picture">
                                    </th>
                                    <td>{{ $user->nombre . ' ' . $user->apellido }} </td>
                                    <td>{{ $user->ci }} </td>
                                    <td>{{ $user->telefono }} </td>
                                    <td>{{ $user->email }} </td>
                                    <td>{{ $user->role }} </td>
                                    <td><span class="{{ $user->estado == 'Activo' ? 'status-on' : 'status-off' }} ">
                                            {{ $user->estado }}
                                        </span>
                                        <div class="form-switch">
                                            @can('Actualizar usuario')
                                                
                                            <input class="form-check-input" type="checkbox"
                                            {{ $user->estado == 'Activo' ? 'checked' : '' }}
                                            wire:click="changeStatus({{ $user->id }})">
                                            @endcan
                                        </div>
                                    </td>
                                    <td>
                                        @can('Eliminar usuario')
                                            
                                        <button class="btn btn-danger" onclick="Confirm('{{ $user->person_id }}')"><i
                                            class="fas fa-trash-alt"></i></button>
                                        @endcan
                                        @can('Actualizar usuario')
                                        <button class="btn btn-purple" wire:click="edit({{ $user->person_id }})"
                                            data-bs-toggle="modal" data-bs-target="#theModal"><i
                                            class="fas fa-edit"></i></button>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <th scope="row" colspan="9">No se encontraron registros </th>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>

                </div>

            </div>
        </x-body>
    </div>
    @include('livewire.users.form')
</div>
