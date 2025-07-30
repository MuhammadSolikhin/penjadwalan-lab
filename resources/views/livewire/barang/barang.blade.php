<div>
    @section('title', 'Barang')

    <div>

        <h2 class="fw-bold fs-3">Barang</h2>
        <span>Halaman untuk mengelola barang</span>
        <hr>

        <livewire:barang.barang-table :currentRoute="$path" />

        <livewire:barang.barang-form-destroy />
    </div>
</div>
