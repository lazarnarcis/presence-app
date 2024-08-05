jQuery(document).ready(function($) {
    function getDailyPresence() {
        $.ajax({
            url: "./php/getDailyPresence.php",
            type: "POST",
            data: {
                start_date: $("#start_date").val(),
                end_date: $("#end_date").val(),
                channel: $("#channel").val(),
            },
            success: function (data) {
                data = JSON.parse(data);
                $('#daily-presence').DataTable().destroy();
                $('#daily-presence').DataTable({
                    pagingType: 'full_numbers',
                    processing: true,
                    data: data
                });
            }
        });
    }
    $(function() {
        let currentDate = new Date();
        let year = currentDate.getFullYear();
        let month = String(currentDate.getMonth() + 1).padStart(2, '0');
        let day = String(currentDate.getDate()).padStart(2, '0');
        let startDateString = `${year}-${month}-${day}`;
        $("#start_date").val(startDateString);

        currentDate = new Date();
        year = currentDate.getFullYear();
        month = String(currentDate.getMonth() + 1).padStart(2, '0');
        day = String(currentDate.getDate()).padStart(2, '0');
        endDateString = `${year}-${month}-${day}`;
        $("#end_date").val(endDateString);

        getDailyPresence();
    });
    $("#end_date, #start_date, #channel").change(function() {
        getDailyPresence();
    });
});