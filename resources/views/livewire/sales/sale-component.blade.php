<div>
    <div class="row g-2">
        <x-header title='Control de ventas' />
        <div class="col-12">
            <x-body subtitle="Cotizacion de ventas">
                <div class="row g-3">
                    <div class="col-md-12">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                data-bs-target="#theModal">
                                <i class="fa-sharp fa-solid fa-file-medical"></i>
                                Nuevo cotización
                            </button>
                        </div>
                    </div>
                    <div class="col-md-7 offset-md-2">
                        <x-search />
                    </div>
                </div>
            </x-body>
        </div>
        <div class="col-12">
            <x-body>
                <div class="row g-3 ">
                    <div class="col-12">
                        <div class="row g-3">
                            @foreach ($sales as $sale)
                                <div class="col-md-6">
                                    <div class="{{ $sale->estado == 'Pendiente' ? 'efectblue' : 'efectgreen' }}">
                                        <div class="cardf">
                                            <div class="row">
                                                <div class="col-md-12 align" wire:click="show('{{ $sale->id }}')"
                                                    data-bs-toggle="modal" data-bs-target="#showDetail">
                                                    {{ $sale->id }}
                                                    <ion-icon
                                                        class="fas {{ $sale->transporte != 0 ? 'fa-shipping-fast' : 'fa-box-open' }}">
                                                    </ion-icon>
                                                </div>
                                                <table>
                                                    <tbody wire:click="show('{{ $sale->id }}')">
                                                        <tr>
                                                            <td> <strong>Cliente:</strong></td>
                                                            <td>{{ $sale->nombre . ' ' . $sale->apellido }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td> <strong>Nº de CI.:</strong></td>
                                                            <td>{{ $sale->ci }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Telefono:</strong></td>
                                                            <td>{{ $sale->telefono }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Correo:</strong> </td>
                                                            <td>{{ $sale->email }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Comision:</strong></td>
                                                            <td>{{ $sale->comision }}Bs</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Precio total:</strong></td>
                                                            <td>{{ number_format($sale->price, 2) }}
                                                                BS</td>
                                                        </tr>
                                                    </tbody>

                                                    <tr>
                                                        <td colspan='2'>
                                                            <div class="col-md-12">
                                                                <div
                                                                    class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                                    {{--              <a href="{{route('sale.show',Crypt::encrypt($sale->id))}}" class="btn btn-primary"><i class="fas fa-eye"></i>  Ver</a> --}}
                                                                    @if ($sale->estado != 'Ejecutado')
                                                                        <a class="btn btn-danger"
                                                                            onClick="Confirm('{{ $sale->id }}')"><i
                                                                                class="fas fa-trash-alt"></i>
                                                                            Eliminar</a>

                                                                        <button class="btn btn-primary"
                                                                            onclick="Fase('{{ $sale->id }}'
                                                                            ,'¿Desea ejecutar la venta?','La venta fue ejecutada')"><i
                                                                                class="fas fa-file-import"></i>
                                                                            Ejecutar</button>
                                                                    @endif

                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-5">
                            {{ $sales->links() }}
                        </div>
                    </div>
                </div>
            </x-body>
        </div>
    </div>
    @include('livewire.sales.form')
    @include('livewire.Sales.show')
</div>
