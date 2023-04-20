$(document).ready(function() {
    $.ajax({
        url: "./php/getNews.php",
        success: function (data) {
            var result = data.slice(1,-1);
            $("#text-news").html(result);
        }
    });
});