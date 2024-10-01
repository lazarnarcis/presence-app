$(document).ready(function() {
    $(document).on("click", ".btn_recovery", function() {
        $(this).attr("disabled", true);
        $.ajax({
            url: "./php/forgot-password.php",
            type: "POST",
            data: $("#forgot_form").serialize(),
            dataType: "json",
            success: function(data) {
                if (data == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: "The email for reset password was sent! The link is valid for 15 minuntes :>",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "index.php";
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data,
                    });
                }
            }
        });
    });
    $('#name').keypress(function(event) {
        if (event.which == 13) {
            event.preventDefault(); 
            $(".btn_recovery").click();
        }
    });
});