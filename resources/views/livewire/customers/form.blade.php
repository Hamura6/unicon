<x-modal title="cliente">
    <form action="">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <x-inputFloat title='Nombre' name='nombre' />
            </div>
            <div class="col-md-6">
                <x-inputFloat title='Apellidos' name='apellido' />
            </div>
            <div class="col-md-6">
                <x-inputFloat title='Numero de Identidad' name='ci' type='number' />
            </div>
            <div class="col-md-6">
                <x-inputFloat title='Telefono' name='telefono' type='number' />
            </div>
            <x-inputFloat title='Correo electronico' name='email' type='email'/>
        </div>
    </form>
</x-modal>
