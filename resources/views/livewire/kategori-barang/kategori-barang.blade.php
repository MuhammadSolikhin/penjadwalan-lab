<div>
    @section('title', 'Kategori Barang')

    <div>

        <h2 class="fw-bold fs-3">Kategori Barang</h2>
        <span>Halaman untuk mengelola kategori barang</span>
        <hr>
        <div id="container-fluid">
            <livewire:kategoribarang.kategori-barang-table :currentRoute="$path" />
        </div>

        <!-- Modal Store -->
        <div wire:ignore.self class="modal fade" id="formModalStore" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    @livewire('kategori-barang.kategori-barang-form-store')
                </div>
            </div>
        </div>

        <!-- Modal Update -->
        <div wire:ignore.self class="modal fade" id="formModalUpdate" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    @if ($selectedHash)
                        @livewire('kategori-barang.kategori-barang-form-update', ['hash' => $selectedHash], key($selectedHash))
                    @endif
                </div>
            </div>
        </div>

        <livewire:kategoribarang.kategori-barang-form-destroy />
    </div>
</div>
