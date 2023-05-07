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
    $(document).on("change", "#change_password", function() {
        if ($(this).val() == "1") {
            $(".div_form_password").show();
        }
    });
});