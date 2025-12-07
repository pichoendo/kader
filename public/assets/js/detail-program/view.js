document.addEventListener("DOMContentLoaded", function () {
    const container = document.querySelector(".verscro");
    const psv = new PerfectScrollbar(container);
    $("#komentar").on("input propertychange", function (e) {
        $("#subKomentar").attr("disabled", e.currentTarget.length == 0);
    });
    $(".comboin").on("change propertychange", function (e) {
        let id = e.currentTarget.id.substr(2, 1);
        if (e.currentTarget.id.startsWith("b2")) {
            $("#inputDate" + id).show();
        } else {
            $("#inputDate" + id).hide();
        }
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
    let loadLogActivity = () => {
        axios
            .get("log/" + $("#id").val())
            .then(function (response) {
                var none =
                    '<div class="d-flex align-items-center justify-content-center" style="height:200px;"><div class="p-2 text-muted">Tidak Ada Aktivitas</div></div>';
                if (response.data) {
                    let data = "";
                    response.data.forEach((dt) => {
                        data +=
                            '<li class="timeline-item timeline-item-transparent ps-4"><span class="timeline-point timeline-point-primary"></span><div class="timeline-event"><div class="timeline-header"><h6 class="mb-0">' +
                            dt.keterangan +
                            '</h6><small class="text-muted">' +
                            dt.created_at +
                            '</small></div><p class="mb-2"></p><div class="d-flex flex-wrap"><div class="avatar me-2"><img src="https://12gbi.info/' + dt.anggota.photo + '" alt="Avatar" class="rounded-circle"/></div><div class="ms-1"><h6 class="mb-0">' +
                            dt.anggota.nama_lengkap +
                            "</h6><span>" +
                            dt.anggota.jabatan.nama +
                            "</span></div></div></div></li>";
                    });
                    $("#log")
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
    loadLogActivity();
});
