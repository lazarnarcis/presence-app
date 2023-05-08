jQuery(document).ready(function($) {
    function getDailyPresence() {
        $.ajax({
            url: "./php/getDailyPresence.php",
            type: "POST",
            data: {
                username: $("#search_user").val()
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
    $(document).on("click", "#search_button", function() {
        getDailyPresence();
    });
    $(function() {
        getDailyPresence();
    });
    $("#search_user").keypress(function(event) {
        if (event.keyCode === 13) {
            $("#search_button").click();
        }
    });
});