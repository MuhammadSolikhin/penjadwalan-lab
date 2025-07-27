<div>
    <div class="modal-header bg-warning">
        <h5 class="modal-title d-flex align-items-center flex-wrap" id="modalTambahLabel">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-edit me-2">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                <path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
            </svg>Ubah Kategori
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
    </div>

    <form wire:submit.prevent="update" class="px-5 py-3">
        <div class="row pb-3">
            <label for="nama-kategori">Nama</label>
            <input wire:model="nama" type="text" class="form-control mx-2" id="nama-kategori"
                placeholder="Masukkan nama kategori barang">
            @error('nama')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="row pb-3">
            <label for="deskripsi-kategori">Deskripsi</label>
            <textarea wire:model="deskripsi" class="form-control mx-2" id="deskripsi-kategori"
                placeholder="Masukkan deskripsi kategori barang"></textarea>
            @error('deskripsi')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="row pb-3 justify-content-end gap-2">
            <button type="button" class="btn btn-sm btn-danger col-12 col-md-2" wire:click="$refresh">Reset</button>
            <button type="submit" class="btn btn-sm btn-warning col-12 col-md-2">Ubah</button>
        </div>
    </form>

</div>
