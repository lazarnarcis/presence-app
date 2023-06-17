$(document).ready(function() {
    $.ajax({
        url: "./php/getUnauthorizedAccounts.php",
        type: "POST",
        success: function (data) {
            data = JSON.parse(data);
            $('#unauthorized-accounts').DataTable().destroy();
            $('#unauthorized-accounts').DataTable({
                data: data
            });
        }
    });
    $(document).on("click", ".authorize_user", function() {
        let user_id = $(this).data("user-id");
        Swal.fire({
            title: "Are you sure?",
            text: "This change cannot be reversed!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes!",
        }).then((result) => {
            if (result.isConfirmed) {
              Swal.fire({
                title: "Success",
                text: "User has been authorized!",
                icon: "success",
                showCancelButton: false,
                confirmButtonColor: "#33cc33",
                confirmButtonText: "OK!",
              }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "./php/authorizeUser.php",
                        type: "POST",
                        data: {
                            user_id: user_id
                        },
                        success: function (data) {}
                    });
                    window.location.reload();
                }
              });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
              Swal.fire("Cancelled", "You gave up on the changes :)", "error");
            }
        });
    });
    $(document).on("click", ".unauthorize_user", function() {
        let user_id = $(this).data("user-id");
        Swal.fire({
            title: "Are you sure?",
            text: "This change cannot be reversed!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes!",
        }).then((result) => {
            if (result.isConfirmed) {
              Swal.fire({
                title: "Success",
                text: "User has been unauthorized!",
                icon: "success",
                showCancelButton: false,
                confirmButtonColor: "#33cc33",
                confirmButtonText: "OK!",
              }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "./php/unauthorizeUser.php",
                        type: "POST",
                        data: {
                            user_id: user_id
                        },
                        success: function (data) {}
                    });
                    window.location.reload();
                }
              });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
              Swal.fire("Cancelled", "You gave up on the changes :)", "error");
            }
        });
    });
});