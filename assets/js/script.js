$(document).ready(function() {
    $.ajax({
        url: "./php/getUsers.php",
        success: function (data) {
            data = JSON.parse(data);
            $('#example').DataTable({
                pagingType: 'full_numbers',
                data: data
            });
        }
    });
});