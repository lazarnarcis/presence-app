$(document).ready(function() {
    $.ajax({
        url: "./php/getMonthlyPresence.php",
        success: function (data) {
            data = JSON.parse(data);
            $('#monthly-presence').DataTable({
                pagingType: 'full_numbers',
                data: data
            });
        }
    });
});