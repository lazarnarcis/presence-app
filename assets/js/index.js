$(document).ready(function() {
    function callUpdateNews() {
        $.ajax({
            url: "./php/getNews.php",
            success: function (data) {
                var result = data.slice(1,-1);
                updatefNews(result);
            }
        });
    }
    $(function() {
        callUpdateNews();
    });
    function updatefNews (text) {
        text = text.replace(/\\n/g, "<br>");
        $("#text-news").html(text);
    }
});