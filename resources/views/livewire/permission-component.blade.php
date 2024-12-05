<div>
    <div class="row ">
        <x-header title='Control de permisos' />
            <x-body title='Asignacion de permisos'>
                <div class="row g-3">
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text">Seleccione un rol</span>
                            <select wire:model.live="role" class="form-select">
                                <option value="Elegir" selected>==Seleccione el roll==</option>
                                @foreach ($roles as $role )
                                    <option value="{{$role->id}}">{{$role->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-7">
                        @can('Asignar permisos')
                            
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button class="btn btn-success" wire:click.prevent="syncAll()"><i class="fa-sharp fa-solid fa-building-circle-check"></i> Asignar permisos</button>
                            <button class="btn btn-danger" onclick="Confirm('{{$role->id}}')"><i class="fa-sharp fa-solid fa-building-circle-xmark"></i> Revocar permisos</button>
                        </div>
                        @endcan
                    </div>
                    <div class="col-md-7 offset-md-2 mb-5">
                        <x-search />
                    </div>
                </div>
                <div class="mobile">
                    <table class="tableDate">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Permisos</th>
                                <th>Asignados</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $permission)
                            <tr>
                                <td>{{$permission->id}}</td>
                                <td>
                                    <div class="form-check ">
                                        @can('Asignar permisos')
                                        <input type="checkbox" class="form-check-input"
                                        wire:change="syncPermission({{$permission->checked==1?'false':'true'}},'{{$permission->name}}')"
                                        id="p{{$permission->id}}"
                                        value="{{$permission->id}}"
                                        class="new-control-input" {{$permission->checked==1?'checked':''}}>
                                        @endcan
                                        <label for="" class="form-check-label">{{$permission->name}}</label>
                                    </div>

                                </td>
                                <td align="center">
                                    <h6>{{App\Models\User::permission($permission->name)->count()}}</h6>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{$permissions->links()}}
            </x-body>
    </div>
</div>
