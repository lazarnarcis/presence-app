$(document).ready(function() {
    $(document).on("click", ".open_user_modal", function() {
        $("#activityModal").modal("show");
        let user = $(this).data("user-name");
        $.ajax({
            url: "./php/getUserActivity.php",
            type: "POST",
            data: {
                user: user
            },
            success: function (data) {
                data = JSON.parse(data);
                $('#user-activity').DataTable().destroy();
                $('#user-activity').DataTable({
                    pagingType: 'full_numbers',
                    processing: true,
                    data: data,
                    order: []
                });
            }
        });
    });
    $(document).on("click", ".authorize_user", function() {
      var $button = $(this);
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
              didOpen: () => {
                const slimSelect = new SlimSelect({
                  select: '#discord-users'
                });
            
                const $swalActions = $('.swal2-actions');
                const $slimSelectDropdown = $('#discord-users').next();
                const $selectElement = $('#discord-users');
            
                $slimSelectDropdown.on('click', function () {
                    $swalActions.hide();
                });
            
                $selectElement.on('change', function () {
                    $swalActions.css('display', 'flex');
                });
            
                $(document).on('click', function (event) {
                    if (!$slimSelectDropdown.is(event.target) && !$slimSelectDropdown.has(event.target).length && event.target !== $selectElement[0]) {
                        $swalActions.css('display', 'flex');
                    }
                });
              },
              preConfirm: () => {
                const selectedUser = document.getElementById('discord-users').value;
                if (!selectedUser) {
                  Swal.showValidationMessage('You must select a user.');
                }
                return selectedUser;
              }
            }).then((result) => {
                if (result.isConfirmed) {
                  $button.html('Authorizing...'); 
                  $button.attr("disabled", true);
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
      var $button = $(this);
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
              $button.html('Unauthorizing...'); 
              $button.attr("disabled", true);
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
    $("#save_info").click(function() {
      if ($("#change_password").val() == "1" && ($("#confirm_password").val() == "" || $("#change_password_input").val() == "")) {
          Swal.fire("Error", "Please enter your new password!", "error");
          return;
      }
      if ($("#confirm_password").val() != $("#change_password_input").val() && $("#change_password").val() == "1") {
          Swal.fire("Error", "The passwords are not identical. Be more careful!", "error");
          return;
      }
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
          $.ajax({
            url: "./php/editUser.php",
            type: "POST",
            data: $("#form_edit_user").serialize(),
            success: function (data) {
                if (data == 1) {
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
                } else {
                    Swal.fire("Error", data, "error");
                }
            }
          });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
          Swal.fire("Cancelled", "You gave up on the changes :)", "error");
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