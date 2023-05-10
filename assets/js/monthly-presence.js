jQuery(document).ready(function($) {
    function getMonthlyPresence() {
        $.ajax({
            url: "./php/getMonthlyPresence.php",
            type: "POST",
            data: {
                username: $("#search_user").val(),
                start_date: $("#start_date").val(),
                end_date: $("#end_date").val()
            },
            success: function (data) {
                data = JSON.parse(data);
                $('#monthly-presence').DataTable().destroy();
                $('#monthly-presence').DataTable({
                    pagingType: 'full_numbers',
                    processing: true,
                    data: data
                });
            }
        });
    }
    $(document).on("click", "#search_button", function() {
        getMonthlyPresence();
    });
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

        getMonthlyPresence();
    });
    $("#end_date").change(function() {
        getMonthlyPresence();
    });
    $("#start_date").change(function() {
        getMonthlyPresence();
    });
    $("#search_user").keypress(function(event) {
        if (event.keyCode === 13) {
            $("#search_button").click();
        }
    });
});