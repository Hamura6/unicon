<x-modal title="produccion">
    <div class="row g-2">
        @foreach ($this->product as $key => $p)
            <div class="col-md-4 col-sm-12">
                <div class="form-floating">
                    <select class="form-select @error('product.' . $key . '.id') is-invalid @enderror "
                        wire:model.defer='product.{{ $key }}.product_id'
                        id="product.{{ $key }}.product_id">
                        <option value="Elegir" selected>Elegir</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->caracteristicas }}</option>
                        @endforeach
                    </select>
                    <label for="product.{{ $key }}.product_id">Seleccione un espacio</label>
                    @error('product.' . $key . '.product_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="form-floating">
                    <input type="number"
                        class="form-control @error('product.' . $key . '.cantidad') is-invalid @enderror"
                        wire:model.defer='product.{{ $key }}.cantidad' placeholder="..."
                        id="product . {{ $key }} .cantidad">
                    <label for="product . {{ $key }} .cantidad">Cantidad</label>
                    @error('product.' . $key . '.cantidad')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="form-floating">
                    <input type="number" class="form-control @error('product.' . $key . '.bajas') is-invalid @enderror"
                        wire:model.defer='product.{{ $key }}.bajas' placeholder="..."
                        id="product . {{ $key }} .bajas">
                    <label for="product . {{ $key }} .bajas">Cantidad</label>
                    @error('product.' . $key . '.bajas')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        @endforeach
        <div class="d-grid gap-2 d-md-flex justify-content-md-start">
            <button class="btn btn-primary " type="button" wire:click="add()"><i class="fas fa-plus"></i>
                Agregar</button>
            <button class="btn btn-danger" type="button" wire:click="reduce()"><i class="fas fa-minus"></i>
                Quitar</button>
        </div>
        @if (!$this->create)
        <div class="col-12">
            <span class="notification">Encargado de la etapa expansora</span>
            <div class="form-floating">
                <input type="text" class="form-control"  name="user"
                 placeholder="..." wire:model="production.user_id" disabled>
                <label for="encargado">Usuario </label>
            </div>        
        </div>
        @endif
        <div class="col-6">
            <div class="form-floating">
                <select class="form-select @error('production.material_id') is-invalid @enderror" id="material_id" wire:model="production.material_id">
                    <option value="Elegir" selected="">Elegir</option>
                    @foreach ($materials as $material)
                        <option value="{{ $material->id }}">{{ $material->nombre }} </option>
                    @endforeach
                </select>
                <label for="material_id">Seleccione un espacio</label>
                @error('production.material_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-6">
            <div class="form-floating">
                <input type="number" class="form-control @error('production.cantidad') is-invalid @enderror " placeholder="..." id="cantidad"
                    wire:model="production.cantidad">
                <label for="cantidad">Cantidad</label>
                @error('production.cantidad')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>





        @foreach ($workers as $i => $w)
            <div class="col-12">
                <h3>Ayudante {{ $i + 1 }} </h3>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="form-floating">
                            <select class="form-select @error('workers.' . $i . '.user_id') is-invalid @enderror "
                                wire:model.defer='workers.{{ $i }}.user_id'
                                id="workers. {{ $i }}.user_id">
                                <option value="Elegir" selected>Elegir</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->full_name }}</option>
                                @endforeach
                            </select>
                            <label for="workers. {{ $i }}.user_id">Seleccione un ayudante</label>
                            @error('workers.' . $i . '.user_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="time"
                                class="form-control @error('workers.' . $i . '.entrada') is-invalid @enderror"
                                wire:model.defer='workers.{{ $i }}.entrada' placeholder="..."
                                id="workers. {{ $i }}.user_id">
                            <label for="workers. {{ $i }}.user_id">hora de entrada</label>
                            @error('workers.' . $i . '.entrada')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="time"
                                class="form-control @error('workers.' . $i . '.salida') is-invalid @enderror"
                                wire:model.defer='workers.{{ $i }}.salida' placeholder="..."
                                id="workers. {{ $i }}.user_id">
                            <label for="workers. {{ $i }}.user_id">hora de salida</label>
                            @error('workers.' . $i . '.salida')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="col-12" align="right">
            <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                <button class="btn btn-primary " type="button" wire:click='addW()'><i class="fas fa-plus"></i>
                    Agregar</button>
                <button class="btn btn-danger" type="button" wire:click='reduceW()'><i class="fas fa-minus"></i>
                    Quitar</button>
            </div>
        </div>
    </div>
</x-modal>
