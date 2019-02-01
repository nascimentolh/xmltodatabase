$(function () {
    //Dropzone
    Dropzone.options.myAwesomeDropzone = {
        paramName: "files[]",
        maxFilesize: 2,
        init: function () {
            this.on("success", function (files, responseText) {
                console.log(responseText.Message);
            })
            
            this.on("queuecomplete", function (file, res) {
                if (this.files[0].status != Dropzone.SUCCESS) {

                } else {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-start',
                        showConfirmButton: false,
                        timer: 3000
                    });

                    Toast.fire({
                        type: 'success',
                        title: 'OK! Query Success'
                    })
                    $.playSound('/dash/plugins/jquery-playsound/definite.mp3')
                    this.removeAllFiles();
                    setTimeout("location.reload()", 2000);
                }
            })
        }
    };

});

