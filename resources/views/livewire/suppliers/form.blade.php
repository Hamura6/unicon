<x-modal title="proveedor">
    <form action="">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <x-inputFloat name='supplier.nombre' title='Nombre' />
            </div>
            <div class="col-md-6">
                <x-inputFloat name='supplier.apellido' title='Apellido' />
            </div>
            <div class="col-md-4">
                <x-inputFloat type='number' name='supplier.ci' title='Nro de CI' />
            </div>
            <div class="col-md-4">
                <x-inputFloat name='supplier.empresa' title='Empresa' />
            </div>
            <div class="col-md-4">
                <x-inputFloat name='supplier.telefono' title='Telefono' type='number' />
            </div>
        </div>
    </form>
</x-modal>
