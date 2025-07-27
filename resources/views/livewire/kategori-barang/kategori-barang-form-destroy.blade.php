<div x-data="{ open: @entangle('showModal') }">
    <div 
        x-show="open"
        x-transition.opacity
        :class="open ? 'modal fade show d-block' : 'modal fade'"
        tabindex="-1"
        :style="open ? 'background: rgba(0,0,0,0.8); z-index: 1050;' : 'display: none;'"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-light">
                    <h5 class="modal-title fw-bold">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
         viewBox="0 0 24 24" fill="none" stroke="currentColor"
         stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
         class="feather feather-trash-2 me-2">
        <polyline points="3 6 5 6 21 6"></polyline>
        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"></path>
        <path d="M10 11v6"></path>
        <path d="M14 11v6"></path>
        <path d="M15 6V4a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2v2"></path>
    </svg>Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" @click="open = false"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <span class="fw-semibold">Nama Kategori Barang:</span> {{ ucfirst($nama) }}
                    </div>
                    <p>Apakah Anda yakin ingin menghapus kategori barang ini?</p>
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
