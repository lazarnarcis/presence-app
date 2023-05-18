$(document).ready(function() {
    $("#save_info").click(function() {
        $.ajax({
            url: "./php/editUser.php",
            type: "POST",
            data: $("#form_edit_user").serialize(),
            success: function (data) {
                if (data == 1) {
                    Swal.fire({
                        title: "Are you sure?",
                        text: "Are you sure you want to make the changes?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes!",
                    }).then((result) => {
                        if (result.isConfirmed) {
                          Swal.fire({
                            title: "Success",
                            text: "Profile data has been changed!",
                            icon: "success",
                            showCancelButton: false,
                            confirmButtonColor: "#33cc33",
                            confirmButtonText: "OK!",
                          }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                          });
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                          Swal.fire("Cancelled", "You gave up on the changes :)", "error");
                        }
                    });
                }
            }
        });
    });
    $(document).on("change", "#change_password", function() {
        if ($(this).val() == "1") {
            $(".div_form_password").show();
        } else {
            $('.div_form_password').hide();
        }
    });
});