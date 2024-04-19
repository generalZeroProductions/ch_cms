function loadPage(routeName) {
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

function loadTab(tabId, routeName, ulId, linkId) {
    fetch("/load-page/" + routeName)
        .then((response) => response.text()) // Parse response as text
        .then((html) => {
            document.getElementById(tabId).innerHTML = html;
        })
        .catch((error) => console.error("Error loading page:", error));
        highlightListItem(ulId, linkId);
}

function loadVertTab(tabId, routeName) {
    fetch("/load-page/" + routeName)
        .then((response) => response.text()) // Parse response as text
        .then((html) => {
            document.getElementById(tabId).innerHTML = html;
        })
        .catch((error) => console.error("Error loading page:", error));

}

function decodeRoutes(encodedString) {
    var decodedString = encodedString.replace(/&quot;/g, '"');
    var array = JSON.parse(decodedString);
    return array;
}

function menuFolder(routes) {
    const menu = document.getElementById("menu");
    const links = menu.getElementsByTagName("a");
    const contents = menu.getElementsByClassName("hidden-content");
    const allRoutes = decodeRoutes(routes);
    for (let i = 0; i < links.length; i++) {
        const content = links[i].nextElementSibling;
        fetch("/load-page/" + allRoutes[i])
        .then((response) => response.text()) // Parse response as text
        .then((html) => {
            content.innerHTML = html;
        })
        .catch((error) => console.error("Error loading page:", error));
    }
    for (let i = 0; i < links.length; i++) {
        links[i].addEventListener("click", function (event) {
            event.preventDefault();
            const content = this.nextElementSibling;
            // Toggle visibility of content
            if (content.style.display === "block") {
                content.style.display = "none";
            } else {
                // Close any other open contents
                for (let j = 0; j < contents.length; j++) {
                    if (
                        contents[j] !== content &&
                        contents[j].style.display === "block"
                    ) {
                        contents[j].style.display = "none";
                    }
                }
                content.style.display = "block";
            }
        });
    }
}
function highlightListItem(ulId, linkId) {
    // Get the <ul> element
    var ulElement = document.getElementById(ulId);
    if (!ulElement) {
        console.log("not found");
    }
    // Get all <a> elements inside the <ul>
    var linkElements = ulElement.getElementsByTagName("a");

    // Loop through each <a> element
    for (var i = 0; i < linkElements.length; i++) {
        // If the current <a> element has the specified id, set its color to blue
        if (linkElements[i].id === linkId) {
            linkElements[i].style.color = "blue";
        } else {
            // Otherwise, set its color to black
            linkElements[i].style.color = "black";
        }
    }
}

function loadEditArticle(article, page_id) {
    const url = "/update_article";
    var articleId = "article_" + article.id;
    var title;
    var body;
    var text;
    console.log(article.title);
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
            var page = document.getElementById("page_id");
            if (page) {
                page.value = page_id;
            }
        });
}

function openBaseModal(action, allTitles, item, pageId) {
    const url = "/open_base_modal";
    var modContent;
    console.log("action = " + action);
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
            modContent = document.getElementById("base-modal-content");

            // Check if modContent is assigned and action is "selectType" before fetching additional content
            if (action === "selectType" && modContent) {
                const surl = "/add_nav_select";
                fetch(surl)
                    .then((response) => response.text())
                    .then((html) => {
                        modContent.innerHTML = html;
                    })
                    .catch((error) =>
                        console.error("Error loading newNavSelect:", error)
                    );
            }
            if (action === "removeItem" && modContent) {
                const surl = "/delete_nav_item";
                var navItem = JSON.parse(item);
                fetch(surl)
                    .then((response) => response.text())
                    .then((html) => {
                        modContent.innerHTML = html;
                        document.getElementById("nav_id").value = navItem.id;
                        document.getElementById("delete_btn").innerHTML =
                            "Confirm Delete " + navItem.title;
                    })
                    .catch((error) =>
                        console.error("Error loading newNavSelect:", error)
                    );
            }
            if (action === "uploadImage" && modContent) {
                const surl = "/image_upload";
                var navItem = JSON.parse(item);
                fetch(surl)
                    .then((response) => response.text())
                    .then((html) => {
                        modContent.innerHTML = html;
                        document.getElementById("page_id").value = pageId;
                        document.getElementById("column_id").value = navItem.id;
                    })
                    .catch((error) =>
                        console.error("Error loading newNavSelect:", error)
                    );
            }
        })
        .catch((error) => console.error("Error loading baseModal:", error));
}

const csrfToken = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");
var linkImagePath;

function closeModal(modalId) {
    var modal = document.getElementById(modalId);
    modal.classList.remove("show");
    // modal.style.display = 'none';

    // Ensure that modal backdrop is also hidden
    var modalBackdrop = document.querySelector(".modal-backdrop");
    // modalBackdrop.style.display = 'none';

    // Remove the modal element from the DOM
    modal.remove();
}

function printPhpVar(phpvar) {
    console.log("var = " + phpvar);
}
