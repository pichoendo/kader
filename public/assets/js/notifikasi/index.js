document.addEventListener("DOMContentLoaded", function () {
    loadNotification();
});
let page = 1;
let first = true;
let clear = (id) => {
    axios
        .post("notifikasi/read", {
            id: id,
        })
        .then(function (response) {
            $("#readed" + id).remove();
        })
        .catch(function (error) {
            console.log(error);
        })
        .then(function () {
            // always executed
        });
};
let loadNotification = () => {
    $("#btnLoad").attr("disabled", true);
    $("#spanLoad").empty().append("Loading");
    $("#load").show();
    axios
        .get("notifikasi/data?page=" + page)
        .then(function (response) {
            var none =
                '<div class="d-flex align-items-center justify-content-center" style="height:200px;"><div class="p-2 text-muted">Tidak Ada Feedback</div></div>';
            if (response.data) {
                let data = "";
                response.data.data.forEach((dt) => {
                    data +=
                        '<li class="list-group-item mb-3 list-group-item-action dropdown-notifications-item"> <div class="" id="fader' +
                        dt.id +
                        '" role="alert"><div class="d-flex"> <div class="flex-shrink-0 me-3"> <div class="avatar"> <span class="avatar-initial rounded-circle bg-label-success">S</span> </div> </div> <div class="flex-grow-1"> <p class="mb-0 text-dark">' +
                        dt.isi +
                        '</p> <small class="text-muted">' +
                        dt.created_at +
                        '</small> </div> <div class="flex-shrink-0 dropdown-notifications-actions" id="readed' +
                        dt.id +
                        '">';
                    if (!dt.readedByMe)
                        data +=
                            '<a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a> <a href="javascript:clear(' +
                            dt.id +
                            ')" class="dropdown-notifications-sdfs"><span class="ti ti-x"></span></a>';
                    data += "</a> </div> </div> </div>  </li> <hr>";
                });
                $("#notifikasi").append(data.length > 0 ? data : none);
                $("#load").hide();
                $("#btnLoad").attr(
                    "disabled",
                    response.data.links.next == null
                );
                if (response.data.links.next != null) {
                    $("#spanLoad").empty().append("Muat Lebih Banyak");
                } else {
                    $("#btnLoad").remove();
                }
                console.log(data);
                $("#fader" + $("#notifikasiValue").val()).attr(
                    "class",
                    "alert alert-primary"
                );

                page++;
                if (first)
                    document
                        .getElementById("fader" + $("#notifikasiValue").val())
                        .scrollIntoView();
                first = false;
            }
        })
        .catch(function (error) {
            console.log(error);
        })
        .then(function () {
            // always executed
        });
};
