$(document).ready(function() {
    $(document).on("change", "#current_year", changeYear);
    function changeYear() {
        let year = $("#current_year").val();
        $.ajax({
            url: "./php/getPublicHolidays.php",
            type: "POST",
            data: {
                year: year
            },
            success: function (data) {
                data = JSON.parse(data);
                $('#public-holidays').DataTable().destroy();
                $('#public-holidays').DataTable({
                    data: data,
                    order: []
                });
            }
        }); 
    }
    $(function() {
        changeYear();
    })
});