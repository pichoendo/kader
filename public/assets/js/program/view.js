document.addEventListener("DOMContentLoaded", function () {
    const container = document.querySelector(".verscro");
    const psv = new PerfectScrollbar(container);
    $("#addProgramModal").modal({ backdrop: "static", keyboard: false });
    let flatpickrRange = $(".flatpickr-range");
    flatpickrRange.flatpickr({
        mode: "range",
    });
});
new FroalaEditor("textarea");
$(".select2").select2({
    ajax: {
        url: "/anggota/departemen/" + $("#departemen").val(),
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
                        text: item.nama_lengkap,
                        id: item.id,
                    };
                }),
            };
        },
    },
    dropdownParent: $("#addDetailProgramModal"),
});

function initDp() {
    const datepicker = $(".date-picker");
    if (datepicker.length) {
        datepicker.each(function () {
            $(this).flatpickr({
                defaultDate: new Date(),
            });
        });
    }
}
$("#addDetailProgramModal").on("hidden.bs.modal", function (e) {
    $(this)
        .find("input,textarea,select")
        .val("")
        .end()
        .find("input[type=checkbox], input[type=radio]")
        .prop("checked", "")
        .end();
});
$("#volume").on("input", function (e) {
    $("#containerVolume").empty();
    for (var i = 1; i <= e.currentTarget.value; i++) {
        $("#containerVolume").append(
            '<div class="col-4"> <label class="form-label w-100">Tanggal Kegiatan ' +
            i +
            '</label> <input name="tanggal[]" required class="form-control date-picker" placeholder="YYYY-MM-DD" readonly="readonly" /> </div> <div class="col-8"> <label class="form-label w-100">Tempat Kegiatan ' +
            i +
            '</label> <input name="tempat[]" required class="form-control" type="text" placeholder="" /> </div>'
        );
    }
    initDp();
});

var $status = {
    0: {
        title: "Draft",
        class: " bg-label-secondary",
    },
    1: {
        title: "Menunggu Pelaksanaan",
        class: " bg-label-info",
    },
    2: {
        title: "Di Tunda",
        class: " bg-label-dark",
    },
    3: {
        title: "Terlaksana",
        class: " bg-label-success",
    },
    4: {
        title: "Review Laporan",
        class: " bg-label-info",
    },
    5: {
        title: "Selesai",
        class: "bg-label-success",
    },
    6: {
        title: "Di Batalkan",
        class: " bg-label-danger",
    },
};

var $status_kegiatan = {
    0: {
        title: "Draft",
        class: " bg-label-secondary",
    },
    1: {
        title: "Menunggu Pelaksanaan",
        class: " bg-label-info",
    },
    2: {
        title: "Di Tunda",
        class: " bg-label-dark",
    },
    3: {
        title: "Terlaksana",
        class: " bg-label-success",
    },
    4: {
        title: "Di Batalkan",
        class: " bg-label-danger",
    },
};
var dt_basic, dt_timeline, dt_timeline_budget;
function loadData() {
    if (dt_basic != null) {
        dt_basic.destroy();
    }
    dt_basic = dt_basic_table.DataTable({
        ajax: "/detail-program/data?" + $("#cari").serialize(),
        columns: [
            { data: "" },
            { data: "" },
            { data: "tahapan" },
            { data: "volume" },
            { data: "anggaran" },
            { data: "kegiatanlist" },
            { data: "" },
            { data: "" },
        ],
        columnDefs: [
            {
                // For Responsive
                className: "align-top text-justify",
                orderable: false,
                searchable: false,
                responsivePriority: 2,
                targets: [2, 3, 5],
                render: function (data, type, full, meta) {
                    return '<span class="text-small small">' + data + "</span>";
                },
            },
            {
                // For Responsive
                className: "align-top",
                orderable: false,
                searchable: false,
                responsivePriority: 2,
                targets: 0,
                render: function (data, type, full, meta) {
                    return "";
                },
            },
            {
                className: "align-top",
                orderable: false,
                searchable: false,
                responsivePriority: 2,
                targets: 1,
                render: function (data, type, full, meta) {
                    return (
                        '<a href="/detail-program/' +
                        full.id +
                        '" class="text-info small text-uppercase">' +
                        full.kode +
                        "</a><br><br>" +
                        full.nama +
                        '<br><a href="/detail-program/' +
                        full.id +
                        '" class="btn btn-sm mt-2 btn-primary waves-effect waves-light">Lihat Detail Program</button>' +
                        "</span>"
                    );
                },
            },
            {
                className: "align-top",
                orderable: false,
                searchable: false,
                responsivePriority: 2,
                targets: 4,
                render: function (data, type, full, meta) {
                    return (
                        '<span class="text-success">' +
                        formatRupiah(data) +
                        "</span>"
                    );
                },
            },
            {
                className: "align-top",
                orderable: false,
                searchable: false,
                responsivePriority: 2,
                targets: 6,
                render: function (data, type, full, meta) {
                    return (
                        '<span class="small">' +
                        full.pic.nama_lengkap +
                        "</span>"
                    );
                },
            },
            {
                className: "align-top",
                targets: 7,
                render: function (data, type, full, meta) {
                    var $status_number = full["status"];

                    if (typeof $status[$status_number] === "undefined") {
                        return data;
                    }
                    return (
                        '<span class="badge ' +
                        $status[$status_number].class +
                        '">' +
                        $status[$status_number].title +
                        "</span>"
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
let month = [
    "Jan",
    "Feb",
    "Mar",
    "Apr",
    "May",
    "Jun",
    "Jul",
    "Aug",
    "Sep",
    "Okt",
    "Nov",
    "Des",
];
function loadDataTimeline() {
    if (dt_timeline != null) {
        dt_timeline.destroy();
    }
    dt_timeline = dt_timeline_table.DataTable({
        ajax: "/detail-program/data?" + $("#cariTimeline").serialize(),
        columnDefs: [
            {
                className: "align-top",
                orderable: false,
                searchable: false,
                responsivePriority: 2,
                targets: 0,
                render: function (data, type, full, meta) {
                    return (
                        '<a href="/detail-program/' +
                        full.id +
                        '" class="text-info small text-uppercase">' +
                        full.kode +
                        "</a><br><br>" +
                        full.nama
                    );
                },
            },
            {
                className: "align-top",
                targets: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                render: function (data, type, full, meta) {
                    let mon = month[meta.col - 1];

                    if (full.kegiatanTimeline.hasOwnProperty(mon)) {
                        var text = "";
                        var $status_number = full.kegiatanTimeline[mon];
                        $status_number.forEach((element) => {
                            text +=
                                '<span class="mb-2 badge ' +
                                $status_kegiatan[element.status].class +
                                '">' +
                                element.tanggal +
                                "</span><br>";
                        });
                        return text;
                    } else {
                        return "";
                    }
                },
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
function loadDataTimelineBudget() {
    if (dt_timeline_budget != null) {
        dt_timeline_budget.destroy();
    }
    dt_timeline_budget = dt_timeline_budget_table.DataTable({
        ajax: "/detail-program/data?" + $("#cariTimelineBudget").serialize(),
        footerCallback: function (row, data, start, end, display) {
            var api = this.api();
            let sum = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            api.data().each(function (data, i, b, c) {
                Object.keys(data.kegiatanTimeline).forEach(function (element) {
                    data.kegiatanTimeline[element].forEach(function (x) {
                        sum[month.indexOf(element)] +=
                            data.anggaran / data.volume;
                    });
                });
            });
            const total = sum.reduce((partialSum, a) => partialSum + a, 0);
            // Update footer
            $(api.column(1).footer()).html(formatRupiah(sum[0]));
            $(api.column(2).footer()).html(formatRupiah(sum[1]));
            $(api.column(3).footer()).html(formatRupiah(sum[2]));
            $(api.column(4).footer()).html(formatRupiah(sum[3]));
            $(api.column(5).footer()).html(formatRupiah(sum[4]));
            $(api.column(6).footer()).html(formatRupiah(sum[5]));
            $(api.column(7).footer()).html(formatRupiah(sum[6]));
            $(api.column(8).footer()).html(formatRupiah(sum[7]));
            $(api.column(9).footer()).html(formatRupiah(sum[8]));
            $(api.column(10).footer()).html(formatRupiah(sum[9]));
            $(api.column(11).footer()).html(formatRupiah(sum[10]));
            $(api.column(12).footer()).html(formatRupiah(sum[11]));
            $(api.column(13).footer()).html(formatRupiah(total));
        },
        columnDefs: [
            {
                className: "align-top",
                orderable: false,
                searchable: false,
                responsivePriority: 2,
                targets: 0,
                render: function (data, type, full, meta) {
                    return (
                        '<a href="/detail-program/' +
                        full.id +
                        '" class="text-info small text-uppercase">' +
                        full.kode +
                        "</a><br><br>" +
                        full.nama
                    );
                },
            },
            {
                className: "align-top",
                orderable: false,
                searchable: false,
                responsivePriority: 2,
                targets: 13,
                render: function (data, type, full, meta) {
                    return (
                        '<span class="mb-2 badge bg-label-info">' +
                        formatRupiah(full.anggaran * 1) +
                        "</span><br>"
                    );
                },
            },
            {
                className: "align-top",
                targets: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                render: function (data, type, full, meta) {
                    let mon = month[meta.col - 1];

                    if (full.kegiatanTimeline.hasOwnProperty(mon)) {
                        var text = "";
                        var $status_number = full.kegiatanTimeline[mon];
                        $status_number.forEach((element) => {
                            text +=
                                '<span class="mb-2 badge ' +
                                $status_kegiatan[element.status].class +
                                '">' +
                                formatRupiah(full.anggaran / full.volume) +
                                "</span><br>";
                        });
                        return text;
                    } else {
                        return "";
                    }
                },
            },
        ],
        searching: false,
        lengthChange: false,
    });
}
let loadFeedback = () => {
    axios
        .get("feedback/" + $("#id").val())
        .then(function (response) {
            var none =
                '<div class="d-flex align-items-center justify-content-center" style="height:200px;"><div class="p-2 text-muted">Tidak Ada Feedback</div></div>';
            if (response.data) {
                let data = "";
                response.data.forEach((dt) => {
                    data +=
                        '<li class="timeline-item timeline-item-transparent ps-4"><span class="timeline-point timeline-point-primary"></span><div class="timeline-event"><div class="timeline-header"><div class="d-flex flex-wrap"><div class="avatar me-2"><img src="https://12gbi.info/' + dt.anggota.photo + '" alt="Avatar" class="rounded-circle"/></div><div class="ms-1"><h6 class="mb-0">' +
                        dt.anggota.nama_lengkap +
                        "</h6><span>" +
                        dt.anggota.jabatan.nama +
                        "<br><small>" +
                        dt.created_at +
                        "</small></span></div></div></div><br><span class='mt-5' >" +
                        dt.feedback +
                        "</span></li>";
                });
                $("#feedback")
                    .empty()
                    .append(data.length > 0 ? data : none);
            }
        })
        .catch(function (error) {
            console.log(error);
        })
        .then(function () {
            // always executed
        });
};
loadFeedback();

var dt_basic_table = $("#data");
var dt_timeline_table = $("#timeline");
var dt_timeline_budget_table = $("#timelineBudget");
if (dt_basic_table.length) {
    loadData();
}
if (dt_timeline_table.length) {
    loadDataTimeline();
}
if (dt_timeline_budget_table.length) {
    loadDataTimelineBudget();
}
