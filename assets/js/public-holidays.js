$(document).ready(function() {
    $.ajax({
        url: "./php/getPublicHolidays.php",
        type: "POST",
        success: function (data) {
            data = JSON.parse(data);
            $('#public-holidays').DataTable().destroy();
            $('#public-holidays').DataTable({
                data: data,
                order: []
            });
        }
    }); 
});