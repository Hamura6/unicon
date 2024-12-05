<x-modal title="Producto">
    <form action="">
        @csrf
        <div class="row g-3">
            <div class="col-md-12">
                <span class="notification">Ingrese nombre el producto</span>
                <x-inputFloat title='Nombre' name='nombre' />
            </div>
            <div class="col-md-6">
                <div class="row g-3">
                    <div class="col-md-6">
                        <span class="notification">Ingrese el precio</span>
                        <x-inputFloat title="Precio" name='precio' type='number' />
                    </div>
                    <div class="col-md-6">
                        <span class="notification">Ingrese la cantidad</span>
                        <x-inputFloat title='Stock' name='stock' type='number' />
                    </div>
                        <div class="col-md-4">
                            <span class="notification">Densidad cm.</span>
                            <x-inputFloat title='Densidad' name='a' type='number' />
                        </div>
                        <div class="col-md-4">
                            <span class="notification">Ancho cm.</span>
                            <x-inputFloat title='Ancho' name='b' type='number' />
                        </div>
                        <div class="col-md-4">
                            <span class="notification">Alto cm.</span>
                            <x-inputFloat title='Alto' name='c' type='number' />
                        </div>


                    <div class="col-md-12">
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="..." style="height: 93px" wire:model='descripcion'></textarea>
                            <label for="floatingTextarea">Descripcion</label>
                            @error('descripcion')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="col-12" align="center">
                    @if ($this->image)
                        <img src="{{ $this->image->temporaryUrl() }} " width="100%" height="180" id='picture'>
                    @else
                        <img src="{{ $this->foto }}" width="100%" height="180" id='picture'
                            wire:target="image">
                    @endif
                    <div>
                        <label for="formFile" class="form-label">Imagen</label>
                        <input class="form-control" type="file" id='file' name='photo'
                            wire:model='image'>
                        @error('image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-modal>
