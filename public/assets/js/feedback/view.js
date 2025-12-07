document.addEventListener("DOMContentLoaded", function () {
    const container = document.querySelector(".verscro");
    const psv = new PerfectScrollbar(container);
    $("#komentar").on("input propertychange", function (e) {
        $("#subKomentar").attr("disabled", e.currentTarget.length == 0);
    });

    let loadFeedback = () => {
        axios
            .get("feedback/data")
            .then(function (response) {
                console.log(response)
                var none =
                    '<div class="d-flex align-items-center justify-content-center" style="height:200px;"><div class="p-2 text-muted">Tidak Ada Feedback</div></div>';
                if (response.data) {
                    let data = "";
                    response.data.data.forEach((dt) => {
                        data +=
                            '<li class="timeline-item timeline-item-transparent ps-4"><span class="timeline-point timeline-point-primary"></span><div class="timeline-event"><div class="timeline-header"><div class="d-flex flex-wrap"><div class="avatar me-2"><img src="https://12gbi.info/' + dt.anggota.photo + '" alt="Avatar" class="rounded-circle"/></div><div class="ms-1"><h6 class="mb-0">' +
                            dt.anggota.nama_lengkap +
                            "</h6><span>" +
                            dt.anggota.jabatan.nama +
                            "<br><small>" +
                            dt.created_at +
                            "</small></span></div></div></div><br><span class='mt-5' ><div class='alert alert-dark' role='alert'>" +
                            dt.feedback +
                            "</div></span></li>";
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
});
