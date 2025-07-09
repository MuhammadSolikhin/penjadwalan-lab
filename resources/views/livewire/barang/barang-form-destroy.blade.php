<div x-data="{ open: @entangle('showModal') }">
    <div 
        x-show="open"
        x-transition.opacity
        :class="open ? 'modal fade show d-block' : 'modal fade'"
        tabindex="-1"
        :style="open ? 'background: rgba(220,53,69,0.8); z-index: 1050;' : 'display: none;'"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" @click="open = false"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <span class="fw-semibold">Nama Barang:</span> {{ ucfirst($nama) }}
                    </div>
                    <div class="mb-3">
                        <span class="fw-semibold">Kategori Barang:</span> {{ ucfirst($kategoriBarang) }}
                    </div>
                    <div class="mb-3">
                        <span class="fw-semibold">Laboratorium:</span> {{ $laboratorium }}
                    </div>
                    <div class="mb-3">
                        <span class="fw-semibold">Status :</span> {{ ucfirst($status) }}
                    </div>
                    @if ($meja) 
                        <div class="mb-3">
                            <span class="fw-semibold">Meja:</span> {{ $meja->nama }} - {{ $meja->laboratoriumUnpam->nama_laboratorium }} ({{ $meja->laboratoriumUnpam->lokasi->nama_lokasi }})
                        </div>
                    @endif
                    <p>Apakah Anda yakin ingin menghapus barang ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="open = false">Batal</button>
                    <button type="button" class="btn btn-danger"
                        wire:click="destroy"
                        wire:loading.attr="disabled"
                        wire:target="destroy">
                        <span wire:loading.remove wire:target="destroy">Hapus</span>
                        <span wire:loading wire:target="destroy">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Menghapus...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
