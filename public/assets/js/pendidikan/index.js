"use strict";
if ($("#has_document").val() == 1) {
    alert("s");
    $("#document_upload").modal();
}
$("#otomatis").on("change", function (a) {
    if (a.currentTarget.checked) {
        $("#berkasView").show();
        $("#mode").val(2);
        $("#form").attr("action", "rkat/submitWithFile");
    }
});
$("#manual").on("change", function (a) {
    if (a.currentTarget.checked) {
        $("#berkasView").hide();
        $("#mode").val(1);
        $("#form").attr("action", "rkat/submit");
    }
});
$('#select2').on('change', () => {
    loadData();
})
$('#select23').on('change', () => {
    initDPD();
    loadData();
})
let initDPD = () => {
    $('#select2').select2({
        select: () => {
            alert("XX")
            loadData()
        },
        ajax: {
            url: "/dpd/dataCombo?dpw_id=" + $('#select23').val(),
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
                    results: $.map(data, function (item) {

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
}

initDPD();
$('#select23').select2({
    select: () => {
        initDPD();
        loadData()
    },
    ajax: {
        url: "/dpw/dataCombo",
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
                results: $.map(data, function (item) {

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


let fv, offCanvasEl;
document.addEventListener("DOMContentLoaded", function (e) {
    (function () {
        const formAddNewRecord = document.getElementById("form-add-new-record");

        setTimeout(() => {
            const newRecord = document.querySelector(".create-new"),
                offCanvasElement = document.querySelector("#add-new-record");

            // To open offCanvas, to add new record
            if (newRecord) {
                newRecord.addEventListener("click", function () {
                    offCanvasEl = new bootstrap.Offcanvas(offCanvasElement);
                    // Empty fields on offCanvas open
                    (offCanvasElement.querySelector(".dt-full-name").value =
                        ""),
                        (offCanvasElement.querySelector(".dt-post").value = ""),
                        (offCanvasElement.querySelector(".dt-email").value =
                            ""),
                        (offCanvasElement.querySelector(".dt-date").value = ""),
                        (offCanvasElement.querySelector(".dt-salary").value =
                            "");
                    // Open offCanvas with form
                    offCanvasEl.show();
                });
            }
        }, 200);

        // FlatPickr Initialization & Validation
        flatpickr(formAddNewRecord.querySelector('[name="basicDate"]'), {
            enableTime: false,
            // See https://flatpickr.js.org/formatting/
            dateFormat: "m/d/Y",
            // After selecting a date, we need to revalidate the field
            onChange: function () {
                fv.revalidateField("basicDate");
            },
        });
    })();
});
$("#anggota_id").each(function (i, obj) {
    $(obj).select2({
        dropdownParent: $('#addKaderModal'),
        ajax: {
            url: "/anggota/data?is_kader=0",
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
                        return {
                            text: item.nama_lengkap,
                            id: item.id,
                        };
                    }),
                };
            },
        },
        placeholder: "Ketik Kata Kunci",
    });
});

$("#jenjang_kader_id").each(function (i, obj) {
    $(obj).select2({
        dropdownParent: $('#addKaderModal'),
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
var dt_basic;
function loadData() {
    if (dt_basic != null) {
        dt_basic.destroy();
    }
    dt_basic = dt_basic_table.DataTable({
        ajax: "pendidikanKader/data?" + $("#cari").serialize(),
        columns: [
            { data: "" },
            { data: "kode" },
            { data: "jenjang.nama", className: "text-small small" },
            { data: "status_kader.nama", className: "text-small small" },
            { data: "peserta_count", className: "text-small small" },
            { data: "peserta_lulus", className: "text-small small" },
            { data: "peserta_tidak_lulus", className: "text-small small" },
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
                        data +
                        "</a><br>"+full.tahun+"</strong>"
                    );
                },
            },
            {
                // Label
                targets: 3,
                render: function (data) {
                    return (
                        '<span class="badge bg-label-info">' + data
                        +
                        '</span>'
                    );
                },
            },

            {
                // Actions
                targets: 7,
                title: "Actions",
                orderable: false,
                searchable: false,
                render: function (data, type, full, meta) {
                    return (
                        '<div class="d-inline-block">' +
                        '<a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="text-primary ti ti-dots-vertical"></i></a>' +
                        '<ul class="dropdown-menu dropdown-menu-end m-0">' +
                        '<li><a href="pendidikanKader/' +
                        full.id +
                        '" class="dropdown-item">View</a></li>' +
                        "</ul></div>"
                    );
                },
            },
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
                        extend: "print",
                        text: '<i class="ti ti-printer me-1" ></i>Print',
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
                        customize: function (win) {
                            //customize print view for dark
                            $(win.document.body)
                                .css("color", config.colors.headingColor)
                                .css("border-color", config.colors.borderColor)
                                .css("background-color", config.colors.bodyBg);
                            $(win.document.body)
                                .find("table")
                                .addClass("compact")
                                .css("color", "inherit")
                                .css("border-color", "inherit")
                                .css("background-color", "inherit");
                        },
                    },
                    {
                        extend: "csv",
                        text: '<i class="ti ti-file-text me-1" ></i>Csv',
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
                    {
                        extend: "pdf",
                        text: '<i class="ti ti-file-description me-1"></i>Pdf',
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
                    {
                        extend: "copy",
                        text: '<i class="ti ti-copy me-1" ></i>Copy',
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
var dt_basic_table = $(".datatables-basic");
if (dt_basic_table.length) {
    loadData();
}

setTimeout(() => {
    $(".dataTables_filter .form-control").removeClass("form-control-sm");
    $(".dataTables_length .form-select").removeClass("form-select-sm");
}, 300);
