<div>
    @section('title', 'Tambah Unit')

    <div>
        <h2 class="fw-bold fs-3">Unit</h2>
        <span>Halaman untuk menambahkan unit</span>
        <hr>
        <div id="container-fluid">
            <form wire:submit.prevent="store">
                
                <div class="row pb-3">
                    <label for="nama-unit">Nama</label>
                    <input wire:model.defer="nama_unit" type="text" class="form-control" id="nama-unit" placeholder="Masukkan nama unit">
                    @error('nama_unit') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="row pb-3">
                    <label for="jenis-unit">Jenis Unit</label>
                    <select wire:model.defer="jenis_unit" class="form-control" id="jenis-unit">
                        <option value="">Pilih Jenis Unit</option>
                        <option value="genaral">General</option>
                        <option value="lembaga">Lembaga</option>
                        <option value="prodi">Prodi</option>
                    </select>
                    @error('jenis_unit') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="row pb-3 justify-content-end gap-2">
                    <button type="button" wire:click="resetForm" class="btn btn-sm btn-danger col-12 col-md-2">Reset</button>
                    <button type="submit" class="btn btn-sm btn-primary col-12 col-md-2">Kirim</button>
                </div>
            </form>
        </div>
    </div>
    
</div>
