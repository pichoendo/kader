document.addEventListener("DOMContentLoaded", function () {
    $("#volume").on("input change", function (e) {
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
        placeholder: "Ketik Kata Kunci",
    });
    initDp();

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
});
