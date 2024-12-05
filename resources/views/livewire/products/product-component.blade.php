<div>
    <div class="row">
        <x-header title='Control  de productos' />
        <x-body>
            <div class="row g-3" style="margin-bottom:48px">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text">Seleccione categoria</span>
                        <select name="" id="" class="form-select" wire:model.live='search'>
                            <option value="">Elegir</option>
                                <option value='vigueta'>Vigueta</option>
                                <option value='plastaformo'>Plastaformo</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-7">
                    @can('Crear Producto')
                        
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                        data-bs-target="#theModal">
                        <i class="fa-sharp fa-solid fa-file-medical"></i>
                        Nuevo Producto
                    </button>
                </div>
                @endcan
                </div>
                <div class="col-md-7 offset-md-2 mb-5">
                    <x-search />
                </div>
                <div class="row g-2">
                    @forelse ($products as $product)
                        <x-octagono>
                            <x-slot name='img'>
                                <img src="{{$product->imagen}}" alt="">
                            </x-slot>
                            <div class="row g-1">
                                <div class="col-12"><strong>{{ $product->nombre }}</strong></div>
                                <div class="col-12">{{ $product->categoria }}</div>
                                <div class="col-12"> <strong>{{ $product->stock }}</strong></div>
                                <div class="col-12">
                                    <h2>{{ $product->precio }} Bs</h2>
                                </div>
                                <x-slot name='action'>
                                    @can('Eliminar producto')
                                        
                                    <button class="btn btn-danger" onclick="Confirm('{{ $product->id }}')"><i
                                        class="fas fa-trash-alt"></i></button>
                                        @endcan
                                        @can('Eliminar producto')
                                            
                                        
                                        <button class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#theModal" wire:click="edit({{ $product->id }})"><i
                                        class="fas fa-edit"></i></button>
                                        @endcan
                                </x-slot>
                            </div>
                        </x-octagono>
                    @empty
                        <div class="col-12 mt-3" align="center">
                            <i class="far fa-frown"></i> No se encontro ningun registro...
                        </div>
                    @endforelse ($products as $product )
                </div>
            </div>
            {{$products->links()}}
        </x-body>
    </div>
    @include('livewire.products.form')
</div>
