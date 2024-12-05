<div wire:ignore.self class="modal fade" id="showDetail" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-xl{{--  modal-fullscreen-lg-down --}}">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Proforma de presupuesto </h5>
                @if (!$this->create)
                <ul class="icon">
                    <a class="a2" href="{{ route('sale.budget', $this->sale->id) }}">
                        <li><i class="fas fa-download"></i></li>
                    </a>
                    <a class="a3" target="_black" href="{{ route('sale.budget', $this->sale->id) }}">
                        <li><i class="fas fa-print"></i></li>
                    </a>
                    <a class="a4" href="https://wa.me/591{{ $this->sale->customer->person->telefono }}">
                        <li><i class="fab fa-whatsapp-square"></i></li>
                    </a>
                </ul>
                @endif

            </div>
            <div class="modal-body">
                @if (!$this->create)
                    <div class="row g-3">
                        <div class="col-12">
                            <h2 class="mb-3">Datos del cliente</h2>
                            <table style="font-size: 18px">
                                <tr>
                                    <td><strong>Fecha: </strong>{{ $this->sale->created_at->format('d-m-Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Nombre:</strong>{{ $this->sale->customer->full_name  }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Encargado:</strong>{{ $this->sale->encargado }} </td>
                                </tr>
                                <tr>
                                    <td><strong>Dirección: </strong>{{ $this->sale->direccion }} </td>
                                </tr>
                                <tr>
                                    <td><strong>Observación: </strong>H{{ $this->sale->observacion + 5 }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-12">
                            <h2>Datos de venta</h2>
                            <div class="mobile">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Productos</th>
                                            <th>Piezas</th>
                                            <th>M.LASD</th>
                                            <th>Aare / m2</th>
                                            <th>Precio</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Plastoformo</td>
                                            <td>{{ $this->sale->products->where('categoria', 'Plastaformo')->sum('pivot.cantidad') }}
                                            </td>
                                            <td rowspan="2">{{ $this->sale->areas->sum('ml') }} </td>
                                            <td rowspan="2">{{ $this->sale->areas->sum('perimetro') }} </td>
                                            <td>{{ $this->sale->products->where('categoria', 'Plastaformo')->sum('pivot.precio') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Viguetas</td>
                                            @if ($this->sale->products->where('categoria', 'Vigueta')->sum('pivot.cantidad'))
                                                <td>{{ $this->sale->areas->sum('espacio') }}</td>
                                            @else
                                                <td>0</td>
                                            @endif
                                            <td>{{ $this->sale->products->where('categoria', 'Vigueta')->sum('pivot.precio') }}
                                                Bs.</td>
                                        </tr>
                                        {{-- <tr>
                                        <td>dfgsd</td>
                                        <td>asdfsa</td>
                                        <td rowspan="2">asdf</td>
                                        <td rowspan="2">asdf</td>
                                        <td>ddfg</td>
                                    </tr> --}}
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4">Precio</td>
                                            <td>{{ $this->sale->products->sum('pivot.precio') }} Bs.</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">Precio con descuento</td>
                                            <td style="color: white">
                                                {{ number_format($this->sale->price, 2) }}
                                                Bs.</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-start mt-3">
                                <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal"
                                    wire:click.prevent="clear()">
                                    <i class="fas fa-window-close mr-1"></i> Cancelar
                                </button>
                               {{--  @if ($this->sale->estado != 'EJECUTADO')
                                    <button class="btn btn-danger"
                                        onclick="Confirm('{{$this->sale->id }}')"><i
                                            class="fas fa-trash-alt"></i> Eliminar
                                    </button>
                                @endif --}}
    
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                                <a class="btn btn-purple"
                                href="{{ route('sale.show', $this->sale->id) }}"><i
                                    class="fas fa-eye"></i> Mas detalles
                            </a>
                                <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                    data-bs-target="#theModal">
                                    <i class="fa-sharp fa-solid fa-file-medical"></i>
                                    Editar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

        </div>
    </div>
</div>
