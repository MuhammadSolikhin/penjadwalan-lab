<div>
    @section('title', 'Ubah Barang')

    <div>
        <h2 class="fw-bold fs-3">Ubah Barang</h2>
        <span>Halaman untuk mengubah barang</span>
        <hr>
        <div id="container-fluid">
            <form wire:submit.prevent="update">
                <div class="row pb-3">
                    <label for="nama-barang">Nama</label>
                    <input wire:model="nama" type="text" class="form-control" id="nama-barang" placeholder="Masukkan nama barang">
                    @error('nama') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="row pb-3">
                    <label for="kategori-barang">Kategori Barang</label>
                    <select wire:model.live="kategori_barang_id" class="form-select" id="kategori-barang">
                        <option value="">Pilih Kategori Barang</option>
                        @foreach($kategoriBarangs as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                        @endforeach
                    </select>
                    @error('kategori_barang_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                @if ($showMejaSelect)
                    <div class="row pb-3">
                        <label for="meja-id">Meja</label>
                        <select wire:model="meja_id" class="form-select" id="meja-id">
                            <option value="">Pilih Meja</option>
                            @foreach($mejas as $meja)
                                <option value="{{ $meja->id }}">{{ $meja->nama }} - {{ $meja->laboratoriumUnpam->nama }} ({{ $meja->laboratoriumUnpam->lokasi->nama_lokasi }})</option>
                            @endforeach
                        </select>
                        @error('meja_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                @endif

                @if ($laboratoriumUnpams)
                    <div class="row pb-3">
                        <label for="laboratorium-id">Laboratorium</label>
                        <select wire:model="lab_id" class="form-select" id="laboratorium-id">
                            <option value="">Pilih Laboratorium</option>
                            @foreach($laboratoriumUnpams as $laboratorium)
                                <option value="{{ $laboratorium->id }}">{{ $laboratorium->nama_laboratorium }} ({{ $laboratorium->lokasi->nama_lokasi }})</option>
                            @endforeach
                        </select>
                        @error('lab_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                @endif

                <div class="row pb-3">
                    <label for="status-barang">Status</label>
                    <select wire:model="status" class="form-select" id="status-barang">
                        <option value="">Pilih Status Barang</option>
                        <option value="digunakan">Digunakan</option>
                        <option value="rusak">Rusak</option>
                        <option value="tidak dipakai">Tidak Dipakai</option>
                        <option value="hilang">Hilang</option>
                    </select>
                    @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="row pb-3">
                    <label for="spesifikasi-barang">Spesifikasi</label>
                    <textarea wire:model="spesifikasi" class="form-control" id="spesifikasi-barang" style="min-height: 100px; max-height: 100px; resize:none;" placeholder="Masukkan spesifikasi barang"></textarea>
                    @error('spesifikasi') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="row pb-3">
                    <label for="deskripsi-barang">Deskripsi</label>
                    <textarea wire:model="deskripsi" class="form-control" id="deskripsi-barang" style="min-height: 100px; max-height: 100px; resize:none;" placeholder="Masukkan deskripsi barang"></textarea>
                    @error('deskripsi') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="row pb-3 justify-content-end gap-2">
                    <button type="button" class="btn btn-sm btn-danger col-12 col-md-2" wire:click="$refresh">Reset</button>
                    <button type="submit" class="btn btn-sm btn-primary col-12 col-md-2">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
