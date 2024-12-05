<div>
    <div class="row">
        <x-header title='Control de roles' />
        <x-body>
            <div class="row g-2">
                @can('Crear rol')
                    
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#theModal" >
                        <i class="fa-sharp fa-solid fa-file-medical"></i>
                        Nuevo rol
                    </button>
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
                                    <th>{{ __('Name') }} </th>
                                    <th>{{ __('Actions') }} </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($roles as $rol)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $rol->name }}</td>

                                        <td>
                                            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                                @can('Eliminar rol')
                                                    
                                                <button class="btn btn-danger"
                                                onclick="Confirm('{{ $rol->id }}')"><i
                                                class="fas fa-trash-alt"></i> Eliminar</button>
                                                @endcan
                                                @can('Editar rol')
                                                    
                                                <button class="btn btn-purple" wire:click="edit({{ $rol->id }})" data-bs-toggle="modal" data-bs-target="#theModal"><i
                                                    class="fas fa-edit"></i>
                                                    Editar</button>
                                                    @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" align="center"><i class="far fa-frown fa-shake"></i> No se
                                            encontro ningun
                                            registro...</td>
                                    </tr>
                                @endforelse ()
                            </tbody>
                        </table>
                    </div>
                    {{ $roles->links() }}
              
                </div>
                @include('livewire.roles.form')
            </div>
        </x-body>
    </div>
</div>
