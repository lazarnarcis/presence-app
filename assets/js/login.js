$(document).ready(function() {
    $(document).on("click", ".btn_login", function() {
        $.ajax({
            url: "./php/login.php",
            type: "POST",
            data: $("#login_form").serialize(),
            success: function(data) {
                if (data == 1) {
                    window.location.href = "index.php";
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
});