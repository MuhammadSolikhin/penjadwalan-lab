import DataTable from 'datatables.net';

export function initLaboratoriumDatatable() {
    const table = new DataTable("#tableLaboratorium", {
        serverSide: true,
        processing: true,
        responsive: true,
        fixedHeader: true,
        ajax: {
            url: "/laboran/api/data-laboratorium",
            method: "GET"
        },
        columns: [
            {
                title: "No",
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
                className: "min-mobile text-center align-middle",
                orderable: false,
                width: "1rem"
            },
            {
                title: "No",
                data: "id_laboratorium",
                visible: false,
            },
            {
                title: "Kode Lab",
                data: "kode_laboratorium",
                className: "text-nowrap align-middle"
            },
            {
                title: "Ruang Lab",
                data: "nama_laboratorium",
                className: "min-mobile text-nowrap align-middle"
            },
            {
                title: "Kapasitas",
                data: "kapasitas_laboratorium",
                className: "text-start text-nowrap align-middle"
            },
            {
                title: "Status",
                data: "status_laboratorium",
                visible: false,
            },
            {
                title: "Lokasi",
                data: "nama_lokasi",
                className: "text-nowrap align-middle"
            },
            {
                title: "Jenis",
                data: "nama_jenislab",
                className: "text-nowrap align-middle"
            },
            {
                title: "Deskripsi",
                data: "deskripsi_laboratorium",
                className: "text-wrap align-middle"
            }
            ,
            {
                title: "Aksi",
                data: null,
                orderable: false,
                searchable: false,
                className: 'min-tablet text-md-center align-middle',
                render: function (data, type, row) {
                    return `<div class="d-flex justify-content-center align-items-center gap-2">
                                <button class="btn btn-sm btn-secondary btn-detail-laboratorium" data-row='${JSON.stringify(row)}'><i data-feather="file-text" width="14px"></i></button>
                                <button class="btn btn-sm btn-warning btn-edit-laboratorium" data-row='${JSON.stringify(row)}'><i data-feather="edit" width="14px"></i></button>
                                <button class="btn btn-sm btn-danger btn-delete-laboratorium" data-row='${JSON.stringify(row)}'><i data-feather="trash-2" width="14px"></i></button>
                            </div>`;
                }
            }
        ],
        // fixedColumns: {
        //     start: 3
        // },
        order: [[2, 'desc']],
        select: {
            style: "multi+shift",
            selector: "td:first-child"
        },
        initComplete: function () {
            moveToolsLaboratorium();
        },
        drawCallback: function (settings) {
            const thElements = document.querySelectorAll('#tableLaboratorium th');
            thElements.forEach(th => {
                th.classList.add('table-white', 'text-nowrap', 'text-center');
            });

            feather.replace();
        }
    });
}

function moveToolsLaboratorium() {
    const wrapper = document.getElementById("tableLaboratorium").closest("#tableLaboratorium_wrapper");

    const search = wrapper.querySelector(".dt-search");
    const length = wrapper.querySelector(".dt-length");
    const info = wrapper.querySelector(".dt-info");
    const paging = wrapper.querySelector(".dt-paging");

    if (search && length && info && paging) {
        const input = search.querySelector("input");
        if (input) {
            input.placeholder = "Pencarian...";
            input.classList.remove("form-control-sm");
            input.classList.add("rounded-start-0", "p-2");
        }

        const select = length.querySelector("select");
         if (select) {
            select.classList.remove("form-select-sm");
        }

        document.getElementById("searchLaboratorium").appendChild(search);
        document.getElementById("sortingLaboratorium").appendChild(length);
        document.getElementById("infoLaboratorium").appendChild(info);
        document.getElementById("pagingLaboratorium").appendChild(paging);
    } else {
        console.warn("Tools Laboratorium Error: Beberapa elemen tidak ditemukan.");
    }
}
