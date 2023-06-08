$(document).ready(function() {
    $.ajax({
        url: "./php/getNews.php",
        success: function (data) {
            var result = data.slice(1,-1);
            updatefNews(result);
        }
    });
    function updatefNews (text) {
        $("#text-news").html(text);
        $("#edit-news-input").html(text);
    }
    $(document).on("click", "#save-news-data", function() {
        let val = $("#edit-news-input").val();
        $.ajax({
            url: "./php/updateNews.php",
            type: "POST",
            data: {
                news: val
            },
            success: function (data) {
                data = JSON.parse(data);
                if (data.news) {
                    Swal.fire("News Updated!", "The changes for the news section have been saved!", "success");
                    updatefNews(data.news);
                }
            }
        });
    });
});