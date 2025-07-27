import DataTable from 'datatables.net';

export function initJenisLabDatatable() {
    const table = new DataTable("#tableJenisLab", {
        serverSide: true,
        processing: true,
        responsive: true,
        fixedHeader: false,
        ajax: {
            url: "/laboran/api/data-jenis-laboratorium",
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
                data: "id_jenis_lab",
                visible: false,
            },
            {
                title: "Nama Jenis Lab",
                data: "nama_jenis_lab",
                className: "min-mobile text-nowrap align-middle"
            },
            {
                title: "Deskripsi",
                data: "deskripsi_jenis_lab",
                className: "text-wrap align-middle",
            },
            {
                title: "Aksi",
                data: null,
                orderable: false,
                searchable: false,
                className: 'min-tablet text-md-center',
                render: function (data, type, row) {
                    return `<div class="d-flex justify-content-center align-items-center gap-2">
                                <button class="btn btn-sm btn-warning btn-edit-jenis-lab" data-row='${JSON.stringify(row)}'><i data-feather="edit" width="14px"></i></button>
                                <button class="btn btn-sm btn-danger btn-delete-jenis-lab" data-row='${JSON.stringify(row)}'><i data-feather="trash-2" width="14px"></i></button>
                            </div>`;
                }
            }
        ],
        // fixedColumns: {
        //     start: 3
        // },
        order: [[2, 'desc']], // Ini bukan dari index kolom javascript tapi dari backend
        select: {
            style: "multi+shift",
            selector: "td:first-child"
        },
        initComplete: function () {
            moveToolsJenisLab();
        },
        drawCallback: function (settings) {
            const thElements = document.querySelectorAll('#tableJenisLab th');
            thElements.forEach(th => {
                th.classList.add('table-white', 'text-nowrap', 'text-center');
            });

            feather.replace();
        }
    });
}

function moveToolsJenisLab() {
    const wrapper = document.getElementById("tableJenisLab").closest("#tableJenisLab_wrapper");

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

        document.getElementById("searchJenisLab").appendChild(search);
        document.getElementById("sortingJenisLab").appendChild(length);
        document.getElementById("infoJenisLab").appendChild(info);
        document.getElementById("pagingJenisLab").appendChild(paging);
    } else {
        console.warn("Tools Jenis Laboratorium Error: Beberapa elemen tidak ditemukan.");
    }
}
