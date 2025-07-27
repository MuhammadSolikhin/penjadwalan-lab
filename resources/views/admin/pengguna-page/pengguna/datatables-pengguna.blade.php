<div class="row p-2">
    <div class="col d-flex align-items-center gap-2">
        <div id="searchPengguna" class="input-group" style="width: auto">
            <span class="input-group-text"><i data-feather="search"></i></span>
        </div>

        <div id="sortingPengguna"></div>
    </div>

    <div class="col text-end">
        <button class="mybtn mybtn-primary text-light ms-2 p-2" data-bs-toggle="modal"
            data-bs-target="#formPenggunaStore">
            <i data-feather="plus"></i>
        </button>
    </div>
</div>

<div class="table-responsive overflow-x-hidden px-2" id="tablePenggunaContainer">
    <table class="table bg-white table-hover table-bordered" id="tablePengguna">
    </table>
</div>

<div class="col-12 p-2 d-flex flex-wrap align-items-center text-center justify-content-between">
    <div id="infoPengguna" class="col-12 col-md-auto mb-3 mb-md-0"></div>
    <div id="pagingPengguna"
        class="col-12 col-md-auto mb-3 mb-md-0 d-flex justify-content-center justify-content-md-auto"></div>
</div>
