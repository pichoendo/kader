
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


var dt_basic;
function loadData() {
    if (dt_basic != null) {
        dt_basic.destroy();
    }
    dt_basic = dt_basic_table.DataTable({
        ajax: "dataHistori/" + $("#id").val(),
        columns: [
            { data: "" },
            {
                data: "created_at"

            },
            { data: "jenjang_kaderisasi.nama", className: "text-small small" },
            { data: "tempat", className: "text-small small" },
            { data: "keterangan", className: "text-small small" },
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

        ],
        displayLength: 7,
        lengthMenu: [7, 10, 25, 50, 75, 100],
        searching: false,
        lengthChange: false,

    });
}
var dt_basic_table = $(".datatables-basic");
if (dt_basic_table.length) {
    loadData();
}