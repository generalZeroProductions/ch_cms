var linkImagePath;
var imagesAsset;
var iconsAsses;
function loadPage(routeName) {
    console.log(routeName);
    fetch("/load-page/" + routeName)
        .then((response) => response.text()) // Parse response as text
        .then((html) => {
            document.getElementById("main_content").innerHTML = html;
            var runScriptsDiv = document.getElementById("runScripts");
            if (runScriptsDiv) {
                var innerHtml = runScriptsDiv.innerHTML;
                var loadTabCall = innerHtml.match(/loadTab\([^)]*\)/);
                var menuFoldCall = innerHtml.match(/menuFolder\([^)]*\)/);
                if (loadTabCall !== null) {
                    eval(loadTabCall[0]);
                }
                if (menuFoldCall !== null) {
                    eval(menuFoldCall[0]);
                }
            }
        })
        .catch((error) => console.error("Error loading page:", error));
}

function loadEditArticle(article, pageName) {
    const url = "/update_article";
    var articleId = "article_" + article.id;
    var title;
    var body;
    var text;

    fetch(url)
        .then((response) => response.text())
        .then((html) => {
            // Replace the content of the specified div with the fetched HTML
            document.getElementById(articleId).innerHTML = html;
            title = document.getElementById("edit_article_title");
            if (title) {
                title.value = article.title;
            }
            body = document.getElementById("edit_article_body");
            if (body) {
                body.innerText = article.body;
            }
            text = document.getElementById("body_text");
            if (text) {
                text.value = article.body;
                body.addEventListener("input", function () {
                    // Update the value of the hidden field body_text with the content of edit_article_body
                    text.value = body.innerText;
                });
            }
            var id = document.getElementById("article_id");
            if (id) {
                id.value = article.id;
            }
            var page = document.getElementById("page_name");
            if (page) {
                page.value = pageName;
            }
        });
}

function showSelectNavType(modContent)
{
    fetch('/add_nav_select')
        .then((response) => response.text())
        .then((html) => {
            modContent.innerHTML = html;
            document.getElementById("base-modal-title").innerHTML =
                "创建新的导航";
        })
        .catch((error) =>
            console.error("Error loading newNavSelect:", error)
        );
}
function removeNavItem(modContent, item)
{
    var navItem = JSON.parse(item);
    document.getElementById("base-modal-title").innerHTML =
    "确认删除记录 " + navItem.title;
    fetch("/delete_nav_item")
        .then((response) => response.text())
        .then((html) => {
            modContent.innerHTML = html;
            document.getElementById("nav_id").value = navItem.id;
            document.getElementById("delete_btn").innerHTML =
                "删除";
            document.getElementById("page_name").value = pageName;
        })
        .catch((error) =>
            console.error("Error loading remove nav item:", error)
        );
}
function showUploadImageStandard(modContent,item,pageName)
{
    var column = JSON.parse(item);
    document.getElementById("base-modal-title").innerHTML = "选择图像";
    fetch('/image_upload')
        .then((response) => response.text())
        .then((html) => {
            modContent.innerHTML = html;
            document.getElementById("page_name").value = pageName;
            document.getElementById("column_id").value = column.id;
            document.getElementById("page_name_use").value = pageName;
            document.getElementById("column_id_use").value = column.id;
        })
        .catch((error) =>
            console.error("Error loading image select form:", error)
        );
}

function openBaseModal(action, allTitles, item, pageName) {
    const url = "/open_base_modal";
    var modContent;
    fetch(url)
        .then((response) => response.text())
        .then((html) => {
            var modalContainer = document.createElement("div");
            modalContainer.innerHTML = html;
            document.body.appendChild(modalContainer);
            var modal = document.getElementById("baseModal");
            modal.classList.add("show");
            modal.style.display = "block";
            modal.dataset.allTitles = allTitles;
            modal.dataset.pageName = pageName;
            modContent = document.getElementById("base-modal-content");
            modal.classList.add("modal-xxl"); // Add extra-large size
            // Check if modContent is assigned and action is "selectType" before fetching additional content
            if (action === "selectType" && modContent) {
                showSelectNavType(modContent);
            }
            if (action === "removeItem" && modContent) {
                removeNavItem(modContent, item);
            }
            if (action === "uploadImage" && modContent) {
                showUploadImageStandard(modContent,item,pageName);
            }
            if (action === "slideShowImage" && modContent) {
                slideItemImageAssign(modContent, item);
            }
            if (action === "createRow" && modContent) {
                fetch('/row_type')
                    .then((response) => response.text())
                    .then((html) => {
                        modContent.innerHTML = html;
                        var modalDialog =
                            document.getElementById("base-modal-size");
                            
                        modalDialog.classList.add("modal-lg");
                        document.getElementById("base-modal-title").innerHTML =
                            "选择要创建的行类型";
                    })
                    .catch((error) =>
                        console.error("Error loading newNavSelect:", error)
                    );
            }
        })
        .catch((error) => console.error("Error loading baseModal:", error));
}

function closeModal() {
    var modal = document.getElementById("baseModal");
    modal.classList.remove("show");
    modal.remove();
}

function printPhpVar(phpvar) {
    console.log("var = " + phpvar);
}

function changePageTitle(page, divId) {
    const pageItem = JSON.parse(page);
    var titleDiv = document.getElementById(divId);
    fetch("/title_change")
        .then((response) => response.text())
        .then((html) => {
            titleDiv.innerHTML = html;
            document.getElementById("page_title").value = pageItem.title;
            document.getElementById("page_id").value = pageItem.id;
        })
        .catch((error) => console.error("Error loading newNavSelect:", error));
}

const csrfToken = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");

function setSessionScreenSize() {
    console.log("trying");
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "session_mobile.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    var postData = "width=" + window.innerWidth;
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Handle the response
                document.body.innerHTML = xhr.responseText;
            } else {
                console.error("Error:", xhr.status);
            }
        }
    };
    xhr.send(postData);
}

function bannerOn() {
    const myCarouselElement = document.querySelector(
        "#carouselExampleCaptions"
    );
    const carousel = new bootstrap.Carousel(myCarouselElement, {
        interval: 2000,
        touch: true,
    });
}
