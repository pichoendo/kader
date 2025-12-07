document.addEventListener("DOMContentLoaded", function () {
    $(".select2").each(function(i, obj) {
        $(obj).select2({
            ajax: {
                url: "dataCombo" ,
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
});
