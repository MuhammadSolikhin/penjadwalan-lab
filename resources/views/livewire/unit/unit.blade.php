<div>    
    @section('title', 'Unit')

    <h2 class="fw-bold fs-3">Unit</h2>
    <span>Halaman untuk mengelola unit</span>
    <hr>
    <div>
        <livewire:unit.unit-table :currentRoute="$path" />
    </div>

    <!-- Modal Store -->
    <div wire:ignore.self class="modal fade" id="formModalStore" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
               @livewire('unit.unit-form-store')
            </div>
        </div>
    </div>

    <!-- Modal Update -->
    <div wire:ignore.self class="modal fade" id="formModalUpdate" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                @if ($selectedHash)
                    @livewire('unit.unit-form-update', ['hash' => $selectedHash], key($selectedHash))
                @endif
            </div>
        </div>
    </div>

</div>
