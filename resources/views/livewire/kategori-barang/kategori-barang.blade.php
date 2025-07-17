<div>
    @section('title', 'Kategori Barang')

    <div>

        <h2 class="fw-bold fs-3">Kategori Barang</h2>
        <span>Halaman untuk mengelola kategori barang</span>
        <hr>
        <div id="container-fluid">
            <div class="row justify-content-end">
                <div class="col-1">
                    <a href="{{ route('kategori-barang.create') }}">
                        <button class="mybtn mybtn-primary text-light ms-2 p-2 mb-2">
                            <i data-feather="plus"></i>
                        </button>
                    </a>
                </div>
            </div>

            <div class="row">
                <livewire:kategoribarang.kategori-barang-table/>
            </div>
        </div>
        <livewire:kategoribarang.kategori-barang-form-destroy/>
    </div>
</div>
