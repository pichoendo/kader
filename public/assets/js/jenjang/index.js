"use strict";
if ($("#has_document").val() == 1) {
    alert("s");
    $("#document_upload").modal();
}
$("#otomatis").on("change", function (a) {
    console.log("show");
    if (a.currentTarget.checked) {
        $("#berkasView").show();
        $("#mode").val(2);
        $("#form").attr("action", "rkat/submitWithFile");
    }
});
$("#manual").on("change", function (a) {
    console.log("hide");
    if (a.currentTarget.checked) {
        $("#berkasView").hide();
        $("#mode").val(1);
        $("#form").attr("action", "rkat/submit");
    }
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
function deleteData(id){
    var crsf = $("[name='_token']").val();

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        customClass: {
          confirmButton: 'btn btn-primary me-3',
          cancelButton: 'btn btn-label-secondary'
        },
        buttonsStyling: false
      }).then((willDelete) => {
                if (willDelete.value) {
                    $.ajax({
                        url: "jenjang/delete",
                        type: "post",
                        beforeSend: function(xhr) {
                            xhr.setRequestHeader('csrf-Token', crsf);
                        },
                        data: {
                            '_token': crsf,
                            'id': id
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Data Berhasil Di Hapus.',
                           
                                imageWidth: 400,
                
                                customClass: {
                                  confirmButton: 'btn btn-primary'
                                },
                                buttonsStyling: false
                              });
                            loadData()
                            // You will get response from your PHP page (what you echo or print)
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });

                } else {

                }
            })


}
var dt_basic;
function loadData() {
    if (dt_basic != null) {
        dt_basic.destroy();
    }
    dt_basic = dt_basic_table.DataTable({
        ajax: "jenjang/data?" + $("#cari").serialize(),
        columns: [
            { data: "" },
            { data: "nama" },
            { data: "jenjang_sebelumnya.nama", className: "text-small small" },
            { data: "jenjang_setelahnya.nama", className: "text-small small" },
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
                // Label
                targets: 2,
                render: function (data) {
                    return (
                        '<span class="badge bg-label-info">' +data
                        +
                        '</span>'
                    );
                },
            },
            {
                // Label
                targets: 3,
                render: function (data) {
                    return (
                        '<span class="badge bg-label-info">' +data
                        +
                        '</span>'
                    );
                },
            },

            {
                // Actions
                targets: 4,
                title: "Actions",
                orderable: false,
                searchable: false,
                render: function (data, type, full, meta) {
                    return (
                        '<div class="d-inline-block">' +
                        '<a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="text-primary ti ti-dots-vertical"></i></a>' +
                        '<ul class="dropdown-menu dropdown-menu-end m-0">' +
                        '<li><a href="jenjang/' +
                        full.id +
                        '" class="dropdown-item">Edit</a></li>' +
                        '<li><a href="#" onClick="deleteData('+full.id+')" class="dropdown-item">Delete</a></li>' +
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
