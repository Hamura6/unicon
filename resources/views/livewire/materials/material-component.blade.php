<div>
    <div class="row">
        <x-header title='Lista de materiales' />
        <x-body>
            <div class="row g-3" style="margin-bottom:48px">
                @can('Crear material')
                    <div class="col-md-12">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                data-bs-target="#theModal">
                                <i class="fa-sharp fa-solid fa-file-medical"></i>
                                Nuevo material
                            </button>
                        </div>
                    </div>
                @endcan
                <div class="col-12">
                    @if ($materials->sum('stock') < 100)
                        <div class="alert alert-danger" role="alert">
                            La cantidad de materia prima en el inventario se encuentra en
                            {{ $materials->sum('stock') }} Kg., se recomienda realizar una nueva compra
                        </div>
                    @endif
                </div>

                <div class="col-md-7 offset-md-2 mb-5">
                    <x-search />
                </div>
                <div class="row g-2">
                    @forelse ($materials as $material)
                        <x-octagono>
                            <x-slot name='img'>
                                <img src="{{ $material->imagen }}" alt="">
                            </x-slot>
                            <div class="row g-1">
                                <div class="col-12"><strong>{{ $material->nombre }}</strong></div>
                                <div class="col-12"> <strong>{{ $material->marca }}</strong></div>
                                <div class="col-12">
                                    <h2>{{ $material->stock }} Kg.</h2>
                                </div>
                                <x-slot name='action'>
                                    @can('Eliminar material')
                                        
                                    <button class="btn btn-danger" onclick="Confirm('{{ $material->id }}')"><i
                                        class="fas fa-trash-alt"></i></button>
                                        
                                        @endcan
                                        @can('Editar material')
                                            
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#theModal"
                                        wire:click="edit({{ $material->id }})"><i class="fas fa-edit"></i></button>
                                        @endcan
                                </x-slot>
                            </div>
                        </x-octagono>
                    @empty
                        <div class="col-12 mt-3" align="center">
                            <i class="far fa-frown fa-shake"></i> No se encontro ningun registro...
                        </div>
                    @endforelse ($materials as $material )

                </div>
                <div style="margin-top: 35px">
                    {{ $materials->links() }}
                </div>
            </div>

        </x-body>
    </div>
    @include('livewire.Materials.form')
</div>
