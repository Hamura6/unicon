<x-modal title="User">
    <form>
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <x-inputFloat title="Nombre" name='nombre' />

            </div>
            <div class="col-md-6">
                <x-inputFloat title="Apellidos" name='apellido' />
            </div>
            <x-inputFloat title="Correo electronico" name='email' />
            <div class="col-md-6">
                <x-inputFloat type='number' title="Telefono" name='telefono' />
            </div>
            <div class="col-md-6">
                <x-inputFloat type='number' title="Numero de Identidad" name='ci' />
            </div>
            <div class="col-md-6">
                <x-inputFloat type='date' title="Fecha de Nacimiento" name='fecha_n' />
            </div>
            <div class="col-md-6">
                <x-inputFloat type='text' title="Direccion" name='direccion' />
            </div>
            <div class="col-md-6">
                <x-select name="role" title='Rol'>
                    @foreach ($roles as $rol)
                        <option value="{{ $rol->id }}"> {{ $rol->name }} </option>
                    @endforeach
                </x-select>
            </div>
            <div class="col-md-6">
                <x-select name="estado" title='Estado'>
                    <option value="Activo">Habilitado</option>
                    <option value="Bloqueado">Deshabilitado</option>
                </x-select>
            </div>
        </div>
    </form>
</x-modal>
