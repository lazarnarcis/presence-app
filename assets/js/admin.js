$(document).ready(function() {
    $.ajax({
        url: "./php/getUnauthorizedAccounts.php",
        type: "POST",
        success: function (data) {
            data = JSON.parse(data);
            $('#unauthorized-accounts').DataTable().destroy();
            $('#unauthorized-accounts').DataTable({
                data: data,
                order: []
            });
        }
    });
    $(document).on("click", ".authorize_user", function() {
        let user_id = $(this).data("user-id");
        $.ajax({
          url: "./php/getDiscordMembers.php",
          type: "POST",
          dataType: "json",
          success: function(data) {
            let listOfDiscordUsers = "<option value='' disabled selected>Select Member</option>";
            if (data && data.length) {
              for(let y = 0; y < data.length; y++) {
                listOfDiscordUsers += "<option value='"+data[y][0]+"'>"+data[y][1]+"</option>";
              }
            }
            Swal.fire({
              title: "Are you sure?",
              text: "This change cannot be reversed!",
              icon: "warning",
              showCancelButton: true,
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#d33",
              confirmButtonText: "Yes!",
              html: `
                <p><strong>Discord User:</strong></p>
                <select id="discord-users" style="width: 100%; height: 35px;">
                  ${listOfDiscordUsers}
                </select>
                <p><small>Select the Discord user that matches.</small></p>
              `,
              preConfirm: () => {
                const selectedUser = document.getElementById('discord-users').value;
                if (!selectedUser) {
                  Swal.showValidationMessage('You must select a user.');
                }
                return selectedUser;
              }
            }).then((result) => {
                if (result.isConfirmed) {
                  $.ajax({
                    url: "./php/authorizeUser.php",
                    type: "POST",
                    data: {
                        user_id: user_id,
                        discord_user_id: result.value
                    },
                    success: function (data) {
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
                    }
                });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                  Swal.fire("Cancelled", "You gave up on the changes :)", "error");
                }
            });
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
              $.ajax({
                url: "./php/unauthorizeUser.php",
                type: "POST",
                data: {
                    user_id: user_id
                },
                success: function (data) {
                  Swal.fire({
                    title: "Success",
                    text: "User has been unauthorized!",
                    icon: "success",
                    showCancelButton: false,
                    confirmButtonColor: "#33cc33",
                    confirmButtonText: "OK!",
                  }).then((result) => {
                    if (result.isConfirmed) {
                      window.location.reload();
                    }
                  });
                }
            });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
              Swal.fire("Cancelled", "You gave up on the changes :)", "error");
            }
        });
    });
});