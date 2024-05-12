

function loadEditArticle(article, location) {
    scrollBackTo = window.scrollY;
    var articleId = "article_" + article.id;
    locItem = JSON.parse(location);
    fetch("/insert_update_article")
        .then((response) => response.text())
        .then((html) => {
            document.getElementById(articleId).innerHTML = html;
            var title = document.getElementById("article_title");
            if (title) {
                title.value = removeHtmlTags(article.title);
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
                cancelBtn.onclick = function () {
                    window.location.href =
                        "/session/cancel?" +
                        locItem.page.title +
                        "?" +
                        scrollBackTo;
                };
            }
            var sizeSelect = document.getElementById('size_select');
   var selectedOptionNumber = parseInt(article.title.match(/<h(\d+)>/)[1]); 

   sizeSelect.value = selectedOptionNumber.toString();

            sizeSelect.addEventListener('change', function() {
                setTitleHeight(sizeSelect.value);
              
            });
            tinymce.init({
                selector: '#article_body', // Replace 'textarea' with the selector for your textarea element
                plugins: 'advlist autolink lists link image charmap  preview',
                toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | link',
                menubar: false, 
                promotion: false,
                license_key: "gpl",
            
            });

            window.scrollTo(0, scrollBackTo);
        });


    }
    function removeHtmlTags(input) {
        return input.replace(/<\/?[^>]+(>|$)/g, "");
    }
    



function setTitleHeight(selectedOption)
{
    var articleTitle = document.getElementById('article_title');
    var selectedClass = 'form-control'; // Start with 'form-control'
    if (selectedOption === '1') {
        selectedClass += ' t1';
    } else if (selectedOption === '2') {
        selectedClass += ' t2';
    } else if (selectedOption === '3') {
        selectedClass += ' t3';
    } else if (selectedOption === '4') {
        selectedClass += ' t4';
    } else if (selectedOption === '5') {
        selectedClass += ' t5';
    }
    articleTitle.className = selectedClass;
}