var imagesAsset;
var iconsAsset;
var scriptAsset;
var allRoutes;
var resizeTimeout;

const csrfToken = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");


function loadPage(routeName) {
    console.log("load page " + routeName);
    fetch("/load_page/" + routeName)
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

function openBaseModal(action, item, location) {
    var modContent;
    fetch("/open_base_modal")
        .then((response) => response.text())
        .then((html) => {
            var modalContainer = document.createElement("div");
            modalContainer.innerHTML = html;
            document.body.appendChild(modalContainer);
            var modal = document.getElementById("baseModal");
            modal.classList.add("show");
            modal.style.display = "block";
            modContent = document.getElementById("base-modal-content");

            if (action === "selectNavType" && modContent) {
                var locItem = JSON.parse(location);
                console.log("location " + locItem);
                modal.dataset.pageId = locItem.page.id;
                showSelectNavType(modContent);
            }
            if (action === "removeItem" && modContent) {
                removeNavItem(modContent, item, location);
            }
            if (action === "uploadImage" && modContent) {
                showUploadImageStandard(modContent, item, location);
            }
            if (action === "createRow" && modContent) {
                modal.classList.add("modal-xxl");
                CreateRowForm(modContent, location, item);
            }
        })
        .catch((error) => console.error("Error loading baseModal:", error));
}

function CreateRowForm(modContent, location) {
    const locItem = JSON.parse(location);
    if(!locItem.row)
    {
        locItem.row = {"row":{"id":0}};
    }
    fetch("/row_type")
        .then((response) => response.text())
        .then((html) => {
            modContent.innerHTML = html;
            var modalDialog = document.getElementById("base-modal-size");
            modalDialog.classList.add("modal-lg");
            document.getElementById("base-modal-title").innerHTML =
                "选择要创建的行类型";
            document.getElementById("page_id_slide").value = locItem.page.id;
            document.getElementById("row_id_slide").value = locItem.row.id;
            document.getElementById("row_index_slide").value =
                locItem.row.index;
            document.getElementById("page_id_1col").value = locItem.page.id;
            document.getElementById("row_id_1col").value = locItem.row.id;
            document.getElementById("row_index_1col").value = locItem.row.index;
            document.getElementById("page_id_2col").value = locItem.page.id;
            document.getElementById("row_id_2col").value = locItem.row.id;
            document.getElementById("row_index_2col").value = locItem.row.index;
            document.getElementById("page_id_tab").value = locItem.page.id;
            document.getElementById("row_id_tab").value = locItem.row.id;
            document.getElementById("row_index_tab").value = locItem.row.index;
            document.getElementById("page_id_left").value = locItem.page.id;
            document.getElementById("row_id_left").value = locItem.row.id;
            document.getElementById("row_index_left").value = locItem.row.index;
            document.getElementById("page_id_right").value = locItem.page.id;
            document.getElementById("row_id_right").value = locItem.row.id;
            document.getElementById("row_index_right").value =
                locItem.row.index;
        })
        .catch((error) => console.error("Error loading newNavSelect:", error));
}

function closeModal() {
    var modal = document.getElementById("baseModal");
    modal.classList.remove("show");
    modal.remove();
}





function handleResize(route) {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(function () {
        console.log("Resizing stopped. Calling updateScreenSettings...");
        window.location.href="/session/screen?"+ window.innerWidth + "?" + route;
    }, 200);
}


function windowVisible()
{
    if (document.visibilityState) {
        document.addEventListener('visibilitychange', function() {
            if (document.visibilityState === 'visible') {
                console.log("User returned to the window");
            } else {
                console.log("User left the window");
            }
        });
    } else {
        console.log("Page Visibility API is not supported");
    }
}


