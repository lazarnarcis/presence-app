$(document).ready(function() {
    $("#save_info").click(function() {
        $.ajax({
            url: "./php/editUser.php",
            type: "POST",
            data: $("#form_edit_user").serialize(),
            success: function (data) {
                if (data == 1) {
                    window.location.reload();
                }
            }
        });
    });
});