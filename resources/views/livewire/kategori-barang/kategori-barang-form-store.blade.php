<div>
    <div class="modal-header mybg-brown text-white">
        <h5 class="modal-title d-flex align-items-center flex-wrap" id="modalTambahLabel">
            <i data-feather="plus-square" class="me-2"></i>Tambah Kategori
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
    </div>

    <form wire:submit.prevent="store" class="px-5 py-3">
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
            <button type="button" class="btn btn-sm btn-danger col-12 col-md-2">Reset</button>
            <button type="submit" class="mybtn btn-sm mybtn-secondary rounded-1 col-12 col-md-2" style="font-size: 12px">Simpan</button>
        </div>
    </form>

</div>
