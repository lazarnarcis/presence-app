$(document).ready(function() {
    $.ajax({
        url: "./php/getDailyPresence.php",
        success: function (data) {
            data = JSON.parse(data);
            $('#daily-presence').DataTable({
                pagingType: 'full_numbers',
                data: data
            });
        }
    });
});