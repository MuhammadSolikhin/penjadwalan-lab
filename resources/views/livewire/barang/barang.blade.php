<div>
    @section('title', 'Barang')

    <div>

        <h2 class="fw-bold fs-3">Barang</h2>
        <span>Halaman untuk mengelola barang</span>
        <hr>
        <div id="container-fluid">
            <div class="row justify-content-end">
                <div class="col-1">
                    <a href="{{ route('barang.create') }}">
                        <button class="btn btn-sm btn-primary mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="25" fill="currentColor" class="bi bi-plus-square" viewBox="0 0 16 16">
                                <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                            </svg>
                        </button>
                    </a>
                </div>
            </div>

            <div class="row">
                <livewire:barang.barang-table/>
            </div>
        </div>
        <livewire:barang.barang-form-destroy/>
    </div>
</div>
