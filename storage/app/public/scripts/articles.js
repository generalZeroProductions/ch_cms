function changePageTitle(location, divId) {
    const locItem = JSON.parse(location);
    var titleDiv = document.getElementById(divId);
    fetch("/title_change")
        .then((response) => response.text())
        .then((html) => {
            titleDiv.innerHTML = html;
            document.getElementById("page_title").value = locItem.page.title;
            document.getElementById("page_id").value = locItem.page.id;
            document.getElementById("scroll_to").value = window.scrollY;
        })
        .catch((error) => console.error("Error loading newNavSelect:", error));
}

function loadEditArticle(article, location) {
    scrollBackTo = window.scrollY;
    var articleId = "article_" + article.id;
    locItem = JSON.parse(location);
    fetch("/insert_update_article")
        .then((response) => response.text())
        .then((html) => {
            // Replace the content of the specified div with the fetched HTML
            document.getElementById(articleId).innerHTML = html;
            // var title = document.getElementById("edit_article_title");
            // if (title) {
            //     title.value = article.title;
            //     // console.log("title is : "+ title.value);
            // }
            // var body = document.getElementById("edit_article_body");
            // if (body) {
            //     body.innerText = article.body;
            // }
            // var text = document.getElementById("body_text");
            // if (text) {
            //     text.value = article.body;
            //     body.addEventListener("input", function () {
            //         // Update the value of the hidden field body_text with the content of edit_article_body
            //         text.value = body.innerText;
            //     });
            // }
            var title = document.getElementById("article_title");
            if (title) {
                title.value = article.title;
                // console.log("title is : "+ title.value);
            }
            var body = document.getElementById("article_body");
            if (body) {
                body.innerHTML = article.body;
            }
            var articleIDField = document.getElementById("article_id");
            if (articleIDField) {
                articleIDField.value = article.id;
            }
            var pageIdField = document.getElementById("page_id");
            if (pageIdField) {
                pageIdField.value = locItem["page"]["id"];
            }
            var scrollField = document.getElementById("scroll_to");
            if (scrollField) {
                scrollField.value = scrollBackTo;
            }
            var cancelBtn = document.getElementById("cancel_article");
            if (cancelBtn) {
                cancelBtn.onclick = function() {
                    window.location.href = "/session/cancel?" + locItem.page.title + "?" + scrollBackTo;
                };
            }
            tinymce.init({
                selector: '#article_body',
                plugins: 'autolink lists link',
                toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | link',
                promotion: false
            });
            window.scrollTo(0, scrollBackTo);
        });
    
}
