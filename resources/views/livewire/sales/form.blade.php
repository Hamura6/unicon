<x-modal title="cotizacion">
    <form action="">
        @csrf
        <div class="row g-2">
            <div style="position: relative;" class="col-md-6">
                <span class="notification">Numero de carnet del cliente</span>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control @error('ci') is-invalid @enderror" wire:model.live='ci'
                        placeholder="...">
                    <label>{{ __('Nº de CI.') }}</label>
                    @error('ci')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                @if ($this->ci && !$scope)
                    <ul class="subsearch">
                        @foreach ($this->results as $result)
                            <li class="subli" wire:click="scoger({{ $result->id }})">{{ $result->nombre }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
            <div class="col-md-6">
                <span class="notification">Numero de celular de cliente</span>
                <x-inputFloat title='Numero de celular' name='telefono' type='number' />
            </div>
            <div class="col-md-6">
                <span class="notification">Nombre del completo del cliente</span>
                <x-inputFloat title='Nombre' name='nombre' />
            </div>
            <div class="col-md-6">
                <span class="notification">Correo electronico del cliente</span>
                <x-inputFloat title='Correo electronico' name='apellido' type='email' />
            </div>
            <div class="col-md-4">
                <span class="notification">Espacio entre viguetas en cm</span>
                {{var_dump($this->espacio)}}

                <div class="form-floating">
                    <select class="form-select @error('espacio') is-invalid @enderror " name='espacio'
                        wire:model.live='espacio'>
                        <option value="Elegir" disabled>Elegir</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->space }}">{{ $product->space + 7 }}</option>
                        @endforeach
                    </select>
                    <label for="floatingSelect">Seleccione un espacio</label>
                    @error('espacio')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <span class="notification">Tipo de armado de la obra</span>
                <x-select title='armado' name='tipo'>
                    <option value="50">Simple</option>
                    <option value="60">Doble</option>
                </x-select>
            </div>
            <div class="col-md-4">
                <span class="notification">Altura del complemento de losa</span>

                <div class="form-floating">
                    <select class="form-select @error('obs') is-invalid @enderror " wire:key="{{ $espacio }}" name='obs' wire:model.live='obs'>
                        <option value="Elegir" disabled>Elegir</option>
                        @foreach ($productsA as $productA)
                            <option value="{{ mb_substr($productA->caracteristicas, 0, 2) }}">
                                {{ mb_substr($productA->caracteristicas, 0, 2) }}</option>
                        @endforeach
                    </select>
                    <label for="floatingSelect">Seleccione un espacio</label>
                    @error('obs')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-12">
                <label for="" class="form-label">Seleccione los productos</label>
                <table class="tableDetail">
                    <tr>
                        <td>
                            <div class="form-check ">
                                <input class="form-check-input"  type="checkbox" value="Plastaformo"
                                    wire:model='product.plastaformo'>
                                <label class="form-check-label" for="flexCheckDefault">
                                    PLASTAFORMO
                                </label>
                            </div>
                        </td>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Vigueta"
                                    wire:model='product.vigueta'>
                                <label class="form-check-label" for="flexCheckDefault">
                                    VIGUETAS
                                </label>
                            </div>
                        </td>
                    </tr>
                </table>



                {{-- {{var_export($product)}} --}}
                @error('product')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-6">
                <span class="notification">Encargado de la obra</span>
                <x-inputFloat name='encargado' title='Encargado' />
            </div>
            <div class="col-md-6">
                <span class="notification">Direccion de la obra</span>
                <div class="form-floating">
                    <textarea class="form-control" placeholder="..." wire:model.defer='dir'></textarea>
                    <label for="floatingTextarea">Ubicacion</label>
                    @error('dir')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-12">
                <label for="" class="control-label"><strong>Costo de servicios</strong></label>
                <table class="tableDetail">
                    <tr>
                        <td>
                            <div class="row justify-content-around g-3">
                                <div class="col-md-5">
                                    <span class="notification">Comision de servicio del asesor</span>
                                    <x-inputFloat name='comision' title='Comision' type='number' />
                                </div>
                                <div class="col-md-5">
                                    <span class="notification">Costo de transporte campo no obligatorio</span>
                                    <x-inputFloat name='trans' title='Transporte' type='number' />
                                </div>


                            </div>
                        </td>
                    </tr>

                </table>

            </div>
            <div class="col-6">
                <label for=""><strong>Base</strong></label>
            </div>
            <div class="col-6">
                <label for=""><strong>Altura</strong> </label>
            </div>
            @foreach ($this->area as $key => $a)
                <div class="col-6">
                    <input type="number" class="form-control @error('area.' . $key . '.base') is-invalid @enderror "
                        wire:model.defer='area.{{ $key }}.base'>
                    @error('area.' . $key . '.base')
                        <span class="text-danger">{{ $message }} </span>
                    @enderror
                </div>
                <div class="col-6">
                    <input type="number" class="form-control @error('area.' . $key . '.height') is-invalid @enderror"
                        wire:model.defer='area.{{ $key }}.height'>
                    @error('area.' . $key . '.height')
                        <span class="text-danger">{{ $message }} </span>
                    @enderror
                </div>
            @endforeach

            <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                <button class="btn btn-primary " type="button" wire:click='add()'><i class="fas fa-plus"></i>
                    Agregar</button>
                <button class="btn btn-danger" type="button" wire:click='reduce()'><i class="fas fa-minus"></i>
                    Quitar</button>
            </div>

        </div>
    </form>
</x-modal>
