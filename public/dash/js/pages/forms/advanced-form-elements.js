$(function () {
    //Dropzone
    Dropzone.options.myAwesomeDropzone = {
        paramName: "files[]",
        maxFilesize: 2,
        init: function () {
            this.on("success", function (files, responseText) {
                console.log(responseText.Message);
            })
            this.on("complete", function (file) {
                this.removeFile(file);
            })
        }
    };

});

