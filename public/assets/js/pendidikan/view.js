
$(".select2").each(function (i, obj) {
    $(obj).select2({
        dropdownParent: $('#updateJenjangModal'),
        ajax: {
            url: "/referensi/jenjang/dataCombo",
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page,
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data.data, function (item) {
                        console.log(item);
                        return {
                            text: item.nama,
                            id: item.id,
                        };
                    }),
                };
            },
        },
        placeholder: "Ketik Kata Kunci",
    });
});

var dt_basic_table = $(".datatables-basic");
if (dt_basic_table.length) {
    loadData();
}
function openEditModal(el){
    let item = JSON.parse(el.getAttribute('data-item'));
    console.log(item)
    $('#nama').val(item.anggota.nama_lengkap)
    $('#judul').val(item.judul_task)
    $('#status').val(item.status)
    $('#ids').val(item.id)
    $('#updateEdit').modal('show');
   
}
var dt_basic;
function loadData() {
    if (dt_basic != null) {
        dt_basic.destroy();
    }
    dt_basic = dt_basic_table.DataTable({
        ajax: `dataPeserta/${ $("#id").val()}?` + $("#cari").serialize(),
        columns: [
            { data: "" },


        ],
        columnDefs: [
            {
                // For Responsive
                className: "control",
                orderable: false,
                searchable: false,
                responsivePriority: 2,
                targets: 0,
                render: function (data, type, full, meta) {
                    return "";
                },
            },
            {
                className: "text-small small",
                orderable: false,
                searchable: false,
                responsivePriority: 2,
                targets: 1,
                render: function (data, type, full, meta) {
                    return (
                        '<strong><a href="pendidikanKader/' +
                        full.id +
                        '" class="text-success text-uppercase text-small small">' +
                        full.anggota.kode +
                        "</a><br>"+full.anggota.nama_lengkap+"</strong>"
                    );
                },
            },
            {
                // Label
                targets: 2,
                render: function (data, type, full, meta) {
                  
                    return full.judul_task
                },
            },
            {
                // Label
                targets: 3,
                render: function (data, type, full, meta) {
                    const statusMap = {
                        1: "Aktif",
                        2: "Lulus",
                        3: "Tidak Lulus"
                    };
                    return (
                        '<span class="badge bg-label-info">' + statusMap[full.status]
                        +
                        '</span>'
                    );
                },
            },

            {
                targets: 4,
                title: "Actions",
                orderable: false,
                searchable: false,
                render: function (data, type, full, meta) {
                    return (
                        '<div class="d-inline-block">' +
                            '<a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">' +
                                '<i class="text-primary ti ti-dots-vertical"></i>' +
                            '</a>' +
                            '<ul class="dropdown-menu dropdown-menu-end m-0">' +
                                `<li>
        <a href="javascript:;" 
           class="dropdown-item"
           onclick='openEditModal(this)' 
           data-item='${JSON.stringify(full)}'>
           View
        </a>
    </li>` +
                            '</ul>' +
                        '</div>'
                    );
                }
            }
        ],
        dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        displayLength: 7,
        lengthMenu: [7, 10, 25, 50, 75, 100],
        buttons: [
            {
                extend: "collection",
                className: "btn btn-label-primary dropdown-toggle me-2",
                text: '<i class="ti ti-file-export me-sm-1"></i> <span class="d-none d-sm-inline-block">Export</span>',
                buttons: [
                    {
                        extend: "excel",
                        text: "Excel",
                        className: "dropdown-item",
                        exportOptions: {
                            columns: [3, 4, 5, 6, 7],
                            // prevent avatar to be display
                            format: {
                                body: function (inner, coldex, rowdex) {
                                    if (inner.length <= 0) return inner;
                                    var el = $.parseHTML(inner);
                                    var result = "";
                                    $.each(el, function (index, item) {
                                        if (
                                            item.classList !== undefined &&
                                            item.classList.contains("user-name")
                                        ) {
                                            result =
                                                result +
                                                item.lastChild.firstChild
                                                    .textContent;
                                        } else if (
                                            item.innerText === undefined
                                        ) {
                                            result = result + item.textContent;
                                        } else result = result + item.innerText;
                                    });
                                    return result;
                                },
                            },
                        },
                    },

                ],
            },
        ],
        searching: false,
        lengthChange: false,
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal({
                    header: function (row) {
                        var data = row.data();
                        return "Details of " + data["full_name"];
                    },
                }),
                type: "column",
                renderer: function (api, rowIdx, columns) {
                    var data = $.map(columns, function (col, i) {
                        return col.title !== "" // ? Do not show row in modal popup if title is blank (for check box)
                            ? '<tr data-dt-row="' +
                            col.rowIndex +
                            '" data-dt-column="' +
                            col.columnIndex +
                            '">' +
                            "<td>" +
                            col.title +
                            ":" +
                            "</td> " +
                            "<td>" +
                            col.data +
                            "</td>" +
                            "</tr>"
                            : "";
                    }).join("");

                    return data
                        ? $('<table class="table"/><tbody />').append(data)
                        : false;
                },
            },
        },
    });
}
