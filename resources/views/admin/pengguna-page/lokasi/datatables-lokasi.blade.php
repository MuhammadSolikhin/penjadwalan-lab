<div class="row p-2">
    <div class="col d-flex align-items-center gap-2">
        <div id="searchLokasi" class="input-group" style="width: auto">
            <span class="input-group-text"><i data-feather="search"></i></span>
        </div>

        <div id="sortingLokasi"></div>
    </div>

    <div class="col text-end">
        <button class="mybtn mybtn-primary p-2" data-bs-toggle="modal" data-bs-target="#formLokasiStore">
            <i data-feather="plus"></i>
        </button>
    </div>
</div>

<div class="table-responsive overflow-x-hidden px-2" id="tableLokasiContainer">
    <table class="table bg-white table-hover table-bordered" id="tableLokasi" style="width: 100%;">
    </table>
</div>

<div class="col-12 p-2 d-flex flex-wrap align-items-center text-center justify-content-between">
    <div id="infoLokasi" class="col-12 col-md-auto mb-3 mb-md-0"></div>
    <div id="pagingLokasi"
        class="col-12 col-md-auto mb-3 mb-md-0 d-flex justify-content-center justify-content-md-auto"></div>
</div>
