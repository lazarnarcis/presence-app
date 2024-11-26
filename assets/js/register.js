$(document).ready(function() {
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
    $(document).on("click", ".btn_register", function() {
        if ($("#username").val() == "") {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please fill in the username!'
            });
            return;
        }
        if ($("#name").val() == "") {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please fill in the name!'
            });
            return;
        }
        if ($("#email").val() == "") {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please fill in the email!'
            });
            return;
        }
        if (isValidEmail($("#email").val().trim()) == false) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'The email must have an email format!'
            });
            return; 
        }
        if ($("#password").val() == "") {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please fill in the password!'
            });
            return;
        }
        $.ajax({
            url: "./php/register.php",
            type: "POST",
            data: $("#register_form").serialize(),
            success: function(data) {
                if (data == 1) {
                    window.location.href = "index.php";
                } else {
                    data = data.replace(/"/g, '');
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data,
                    });
                }
            }
        });
    });
    $('#name, #username, #email, #password').keypress(function(event) {
        if (event.which == 13) {
            $(".btn_register").click();
        }
    });
    $(".btn_login").click(function() {
        window.location.href = "login.php";
    });
});