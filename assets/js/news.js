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
        $("#edit-news-input").val(text);
    }
    $(document).on("click", "#save-news-data", function() {
        let val = $("#edit-news-input").val();
        if (val == "") return;
        let el = $(this);
        el.attr("disabled", true);
        el.val("Wait to send emails to all :>");
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
                    el.attr("disabled", false);
                    el.val("Save");
                    $("#editNewsModal").modal("hide");
                }
            }
        });
    });
    $(document).on("click", ".edit_news", function() {
        callUpdateNews();
        $("#editNewsModal").modal("show");
    });
    $(document).on("click", ".show_all_news", function() {
        $.ajax({
            url: "./php/getAllNews.php",
            success: function (data) {
                data = JSON.parse(data);
                console.log(data);
                $('#last-news-table').DataTable().destroy();
                $('#last-news-table').DataTable({
                    data: data,
                    order: []
                });
                $("#lastNewsModal").modal("show");
            }
        });
    });
    $(document).on("click", ".cancel_edit_news_modal", function() {
        $("#editNewsModal").modal("hide");
    });
});