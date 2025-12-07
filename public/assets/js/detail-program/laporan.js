document.addEventListener("DOMContentLoaded", function () {
    const previewTemplate = `<div class="dz-preview dz-file-preview">
    <div class="dz-details">
      <div class="dz-thumbnail">
        <img data-dz-thumbnail>
        <span class="dz-nopreview">No preview</span>
        <div class="dz-success-mark"></div>
        <div class="dz-error-mark"></div>
        <div class="dz-error-message"><span data-dz-errormessage></span></div>
        <div class="progress">
          <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100" data-dz-uploadprogress></div>
        </div>
      </div>
      <div class="dz-filename" data-dz-name></div>
      <div class="dz-size" data-dz-size></div>
    </div>
    </div>`;

    function attrBtn() {
        $("#sub").attr("disabled", jobs != 0);
    }
    let addFile = (file) => {
        let inp =
            '<input type="hidden" name="dokumentasi[]" value="' + file + '"/>';
        $("#fileContainer").append(inp);
    };
    let jobs = 0;
    const dropzoneMulti = new Dropzone("#theform", {
        previewTemplate: previewTemplate,
        addRemoveLinks: true,
        url: "/upload/dokumentasi",
        autoProcessQueue: true,
        uploadMultiple: false,
        removedfile: function (file) {
            $.ajax({
                url: "/upload/delete",
                type: "post",
                data: {
                    file: file.uploadURL,
                },
                headers: {
                    "X-CSRF-TOKEN": $('input[name="_token"]').attr("value"),
                },
                success: function (response) {},
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                },
            });
            $('input[value="' + file.uploadURL + '"]').remove();
            file.previewElement.remove();
        },
        headers: {
            "X-CSRF-TOKEN": $('input[name="_token"]').attr("value"),
        },
        parallelUploads: 100,
        maxFiles: 100,
        init: function () {
            $("#theform").show();

            this.on("sending", function (file, xhr, formData) {
                jobs++;
                attrBtn();
            });
            this.on("success", function (files, response) {
                files.uploadURL = response.result;
                jobs--;
                addFile(response.result);
                attrBtn();
            });
            this.on("error", function (files, response) {
                console.log("error");
                jobs--;
                attrBtn();
            });
        },
    });
});
function removeGmbr(a) {
    $.ajax({
        url: "/upload/deleteById",
        type: "post",
        data: {
            id: a,
        },
        headers: {
            "X-CSRF-TOKEN": $('input[name="_token"]').attr("value"),
        },
        success: function (response) {
            $("#prv" + a).remove();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            console.log(textStatus, errorThrown);
        },
    });
}
