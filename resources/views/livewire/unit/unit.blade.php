<div>
    @section('title', 'Unit')

    <div>

        <h2 class="fw-bold fs-3">Unit</h2>
        <span>Halaman untuk mengelola barang</span>
        <hr>
        <div id="container-fluid">
            <div class="row justify-content-end">
                <div class="col-1">
                    <a href="{{ route('unit.create') }}">
                        <button class="mybtn mybtn-primary text-light ms-2 p-2 mb-2">
                            <i data-feather="plus"></i>
                        </button>
                    </a>
                </div>
            </div>

            <div class="row">
                <livewire:unit.unit-table/>
            </div>
        </div>

    </div>
</div>
