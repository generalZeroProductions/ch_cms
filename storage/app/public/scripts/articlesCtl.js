function loadEditArticle(article, location) {
    var articleId = "article_" + article.id;
    locItem = JSON.parse(location);
    fetch("/update_article")
        .then((response) => response.text())
        .then((html) => {
            // Replace the content of the specified div with the fetched HTML
            document.getElementById(articleId).innerHTML = html;
            var title = document.getElementById("edit_article_title");
            if (title) {
                title.value = article.title;
                // console.log("title is : "+ title.value);
            }
            var body = document.getElementById("edit_article_body");
            if (body) {
                body.innerText = article.body;
            }
            var text = document.getElementById("body_text");
            if (text) {
                text.value = article.body;
                body.addEventListener("input", function () {
                    // Update the value of the hidden field body_text with the content of edit_article_body
                    text.value = body.innerText;
                });
            }
            var articleIDField = document.getElementById("article_id");
            if (articleIDField) {
                articleIDField.value = article.id;
            }
            var pageIdField = document.getElementById("page_id");
            if (pageIdField) {
                pageIdField.value = locItem['page']['id'];
            }
        });
}