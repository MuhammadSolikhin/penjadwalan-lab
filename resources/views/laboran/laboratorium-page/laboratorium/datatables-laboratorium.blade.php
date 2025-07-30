<div class="row p-2">
    <div class="col d-flex align-items-center gap-2">
        <div id="searchLaboratorium" class="input-group" style="width: auto">
            <span class="input-group-text"><i data-feather="search"></i></span>
        </div>
        <div id="sortingLaboratorium"></div>
    </div>

    <div class="col text-end">
        <button class="mybtn mybtn-primary p-2" data-bs-toggle="modal" data-bs-target="#formLaboratoriumStore">
            <i data-feather="plus"></i>
        </button>
    </div>
</div>

<div class="table-responsive px-2" id="tableLaboratoriumContainer">
    <table class="table bg-white table-hover table-bordered" id="tableLaboratorium" style="width: 100%;">
    </table>
</div>

<div class="col-12 p-2 d-flex flex-wrap align-items-center text-center justify-content-between">
    <div id="infoLaboratorium" class="col-12 col-md-auto mb-3 mb-md-0"></div>
    <div id="pagingLaboratorium"
        class="col-12 col-md-auto mb-3 mb-md-0 d-flex justify-content-center justify-content-md-auto"></div>
</div>
