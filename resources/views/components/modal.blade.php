@props(['title' => 'title'])
<div wire:ignore.self class="modal fade" tabindex="-1" role="dialog" id="theModal" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    {{ $this->create ? 'Crear |' : 'Editar |' }} {{ $title }}
                </h5>
                <h6 class="text-center text-warning" wire:loading>
                    <div class="spinner-border spinner-border-sm" role="status">
                    </div>
                </h6>
            </div>
            <div class="modal-body">
                {{ $slot }}

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal"
                    wire:click.prevent="clear()">
                    <i class="fas fa-window-close mr-1"></i>Cancelar
                </button>
                @if ($this->create)
                    <button type="submit" class="btn btn-success close-modal" wire:click.prevent="store()" >
                        <i class="fas fa-save mr-1"></i> Guardar
                    </button>
                @else
                    <button type="submit" class="btn btn-success close-modal" wire:click.prevent="update()" >
                        <i class="fas fa-edit mr-1"></i>Actualizar
                    </button>
                @endif
            </div>
        </div>
    </div>

</div>
