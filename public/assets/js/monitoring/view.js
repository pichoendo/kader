

var groupColumn = 0;
let panjang = $('#panjang').val() * 1;
alert(panjang)
var dt_basic, dt_timeline, dt_timeline_budget;
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


function loadData() {
    let col = '[{ "data": "nama" } '
    let col2 = [];
    for (var i = 0; i < $('#panjang').val(); i++) {
        col += ',{ "data": "" }'
        col2.push(i + 1)
    }
    col += ',{ "data": "count_total" }]'
    col = JSON.parse(col)

    if (dt_basic != null) {
        dt_basic.destroy();
    }
    dt_basic = dt_basic_table.DataTable({
        ajax:
            "/monitoring/data?" +
            $("#cari1").serialize(),
        columns: col,
        columnDefs: [
            {
                className: "text-small small",
                orderable: false,
                searchable: false,
                responsivePriority: 2,
                targets: col2,
                render: function (data, type, full, meta) {
                    let value = 0;

                    const columnToCounterMap = {
                        1: ["1"],
                        2: ["2", "3"], // gabungan
                        3: ["5"], // gabungan
                    };
                
                    const counters = columnToCounterMap[meta.col];
                
                    if (counters && full.counter) {
                        counters.forEach(key => {
                            value += Number(full.counter[key]) || 0;
                        });
                    }
                
                    return value;
                },
            },
            {
                className: "text-small small",
                orderable: false,
                searchable: false,
                responsivePriority: 2,
                targets: col.length - 1,
                render: function (data, type, full, meta) {
                    let all = 0
                    Object.keys(full.counter).forEach(function (key) {
                        console.log(full.counter)
                        all += full.counter[key]
                    });
                    return all;
                },
            },
        ],
        ordering: false,
        displayLength: 1000,
        searching: false,
        lengthChange: false,
        drawCallback: function (settings) {
            $('#total_anggota').empty().append()
            var api = this.api();
            var rows = api
                .rows({
                    page: "current",
                })
                .nodes();
            console.log(rows)
            var last = null;

            api.data().each(function (data, i, b, c) {
                if (last !== data.province_id) {
                    $(rows)
                        .eq(i)
                        .before(
                            '<tr class="group"><td>' + data.provinsi.nama + '</td></tr>'
                        )

                    last = data.province_id;
                }
            });
        },
        footerCallback: function (row, data, start, end, display) {
            var api = this.api();

            let sum = Array(panjang + 1).fill(0)

            api.data().each(function (data, i, b, c) {

                Object.keys(data.counter).forEach(function (key) {
                    if (data.counter[key] > 0) {
                        sum[key - 1] += data.counter[key]
                        sum[panjang] += data.counter[key] * 1
                    }
                });
            });

            sum.forEach((a, b) => {
               if(a)
                    $(api.column(b + 1).footer()).html(a);
            });

        },

    });
}





var dt_basic_table = $("#data");
var dt_timeline_table = $("#timeline");
var dt_timeline_budget_table = $("#timelineBudget");

loadData();
