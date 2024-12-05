<x-modal title='Material'>
    <form action="">
        @csrf
        <div class="row g-3">

            <div style="position: relative;" class="col-md-6">
                <span class="notification">Ingrese el nombre del producto</span>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control @error('material.nombre') is-invalid @enderror"
                        wire:model.live="material.nombre" name="material.nombre" id="floatingInputInvalid" placeholder="...">
                    <label for="floatingInputInvalid">{{ __('Nombre') }} </label>
                    @error('material.nombre')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                @if (!empty($this->material['nombre'])  && $this->create)
                    <ul class="subsearch">
                        @foreach ($this->results as $result)
                            <li class="subli" wire:click="scoger({{ $result->id }})">{{ $result->nombre }}  --- {{$result->marca}} </li>
                        @endforeach
                    </ul>
                @endif
            </div>


            <div class="col-md-6">
                <span class="notification">Ingrese la marca del producto</span>
                <x-inputFloat title='Marca' name='material.marca' />
            </div>

            @if ($create)
                <div class="col-md-6">
                    <span class="notification">Ingrese el precio total</span>
                    <x-inputFloat title='Precio' name='buy.precio' type='number' />
                </div>
                <div class="col-md-6">
                    <span class="notification">Ingrese la cantidad en Kg.</span>
                    <x-inputFloat title='Cantidad' name='buy.cantidad' type='number' />
                </div>
                <div class="col-md-12">

                    <x-select name='buy.supplier_id' title='proveedores'>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->nombre.' '.$supplier->apellido }}</option>
                        @endforeach
                    </x-select>
                </div>
            @else
                <div class="col-md-12">
                    <x-inputFloat title='Stock' name='material.stock' type='number' />
                </div>
            @endif
            <div class="col-12" align="center">
                @if ($image)
                    <img src="{{ $image->temporaryUrl() }} " width="60%" height="200" id='picture'>
                @else
                    <img src="{{ !empty($this->material['foto']) ? $this->material['foto']: '' }}" width="60%" height="200" id='picture'
                        wire:target="image">
                @endif
                <div>
                    <label for="formFile" class="form-label">Imagen</label>
                    <input class="form-control" type="file" id='file' name='photo' wire:model='image'>
                    @error('image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </form>
</x-modal>
