$(document).ready(function() {
    $(document).on("click", ".btn_change", function() {
        var password = $("#password").val();
        var confirmPassword = $("#confirm_password").val();
        
        if (password !== confirmPassword) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "Passwords do not match! Please enter them again.",
            });
            return;  
        }

        if (password.length < 8) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "Password must be at least 8 characters long!",
            });
            return; 
        }

        $.ajax({
            url: "./php/change-password.php",
            type: "POST",
            data: $("#change_form").serialize(),
            dataType: "json",
            success: function(data) {
                if (data == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: "The password has been changed!",
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

    $('#password, #confirm_password').keypress(function(event) {
        if (event.which == 13) {
            $(".btn_change").click();
        }
    });
});
