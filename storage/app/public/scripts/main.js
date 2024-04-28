var imagesAsset;
var iconsAsset;
var scriptAsset;
var allRoutes;
var resizeTimeout;
var allImages;

const csrfToken = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");

function loadPage(routeName, scrollTo) {
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
            window.scrollTo(0, scrollTo);
        })
        .catch((error) => console.error("Error loading page:", error));
}
function openMainModal(action, item, location, modalSize) {
    var dialogElement = document.getElementById("main_modal_dialog");
    dialogElement.className = "modal-dialog " + modalSize;
    $("#main_modal").modal("show");
    var modBody = document.getElementById("main_modal_body");

    if (action === "selectNavType" && modBody) {
        var locItem = JSON.parse(location);
        modal.dataset.pageId = locItem.page.id;
        showSelectNavType(modBody);
    }
    if (action === "removeItem" && modBody) {
        removeNavItem(modBody, item, location);
    }
    if (action === "uploadImage" && modBody) {
        showUploadImageStandard(modBody, item, location);
    }
    if (action === "createRow" && modBody) {
        CreateRowForm(modBody, location, item);
    }
    if (action === "editSlideshow" && modBody) {
        editSlidesForm(modBody, location, item);
    }
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
    document.getElementById("main_modal_label").innerHTML =
        "选择要创建的行类型";
    const locItem = JSON.parse(location);
    if (!locItem.row) {
        locItem.row = { id: 0, index: 0 };
    }

    fetch("/row_type")
        .then((response) => response.text())
        .then((html) => {
            modContent.innerHTML = html;

            document.getElementById("page_id_slide").value = locItem.page.id;
            document.getElementById("row_index_slide").value =
                locItem.row.index;
            document.getElementById("page_id_1col").value = locItem.page.id;
            document.getElementById("row_index_1col").value = locItem.row.index;

            document.getElementById("page_id_2col").value = locItem.page.id;
            document.getElementById("row_index_2col").value = locItem.row.index;

            document.getElementById("page_id_tab").value = locItem.page.id;
            document.getElementById("row_index_tab").value = locItem.row.index;

            document.getElementById("page_id_left").value = locItem.page.id;
            document.getElementById("row_index_left").value = locItem.row.index;

            document.getElementById("page_id_right").value = locItem.page.id;
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
        window.location.href =
            "/session/screen?" +
            window.innerWidth +
            "?" +
            route +
            "?" +
            window.scrollY;
    }, 200);
}

function windowVisible() {
    if (document.visibilityState) {
        document.addEventListener("visibilitychange", function () {
            if (document.visibilityState === "visible") {
                console.log("User returned to the window");
            } else {
                console.log("User left the window");
            }
        });
    } else {
        console.log("Page Visibility API is not supported");
    }
}
