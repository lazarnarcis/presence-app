$(document).ready(function() {
    function getDailyPresence() {
        $.ajax({
            url: "./php/getDailyPresence.php",
            type: "POST",
            data: {
                user_id: $("#presence_users").val()
            },
            success: function (data) {
                data = JSON.parse(data);
                $('#daily-presence').DataTable().destroy();
                $('#daily-presence').DataTable({
                    pagingType: 'full_numbers',
                    data: data
                });
            }
        });
    }
    $(document).on("change", "#presence_users", function() {
        getDailyPresence();
    });
    $(function() {
        setTimeout(()=>{
            jQuery("#presence_users").select2();

        }, 0)
        getDailyPresence();
    });
});