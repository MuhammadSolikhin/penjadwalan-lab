<div>
    @section('title', 'Tambah Kategori Barang')

    <div>
        <h2 class="fw-bold fs-3">Kategori Barang</h2>
        <span>Halaman untuk menambahkan kategori barang</span>
        <hr>
        <div id="container-fluid">
            <form wire:submit.prevent="store">
                <div class="row pb-3">
                    <label for="nama-kategori">Nama</label>
                    <input wire:model="nama" type="text" class="form-control" id="nama-kategori" placeholder="Masukkan nama kategori barang">
                    @error('nama') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="row pb-3">
                    <label for="deskripsi-kategori">Deskripsi</label>
                    <textarea wire:model="deskripsi" class="form-control" id="deskripsi-kategori" placeholder="Masukkan deskripsi kategori barang"></textarea>
                    @error('deskripsi') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="row pb-3 justify-content-end gap-2">
                    <button type="button" class="btn btn-sm btn-danger col-12 col-md-2">Reset</button>
                    <button type="submit" class="btn btn-sm btn-primary col-12 col-md-2">Kirim</button>
                </div>
            </form>
        </div>
    </div>
    
</div>
