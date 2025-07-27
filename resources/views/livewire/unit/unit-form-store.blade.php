<div>
    <div class="modal-header mybg-brown text-white">
        <h5 class="modal-title d-flex align-items-center flex-wrap" id="modalTambahLabel">
            <i data-feather="plus-square" class="me-2"></i>Tambah Unit
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
    </div>

    <form wire:submit.prevent="store" class="px-5 py-3">

        <div class="row pb-3">
            <label for="nama-unit">Nama</label>
            <input wire:model.defer="nama_unit" type="text" class="form-control mx-2" id="nama-unit"
                placeholder="Masukkan nama unit">
            @error('nama_unit')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="row pb-3">
            <label for="jenis-unit">Jenis Unit</label>
            <select wire:model.defer="jenis_unit" class="form-control mx-2" id="jenis-unit">
                <option value="">Pilih Jenis Unit</option>
                <option value="genaral">General</option>
                <option value="lembaga">Lembaga</option>
                <option value="prodi">Prodi</option>
            </select>
            @error('jenis_unit')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="row pb-3 justify-content-end gap-2">
            <button type="button" wire:click="resetForm" class="btn btn-sm btn-danger col-12 col-md-2">Reset</button>
            <button type="submit" class="mybtn btn-sm mybtn-primary rounded-1 col-12 col-md-3">Simpan</button>
        </div>
    </form>
</div>
