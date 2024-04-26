var imagesAsset;
var iconsAsset;
var scriptAsset;
var allRoutes;

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

function showUploadImageStandard(modContent, item, location) {
    var itemItem = JSON.parse(item);
    var locItem = JSON.parse(location);
    document.getElementById("base-modal-title").innerHTML = "选择图像";
    fetch("/image_upload")
        .then((response) => response.text())
        .then((html) => {
            modContent.innerHTML = html;
            document.getElementById("page_id").value = locItem.page.id;
            document.getElementById("column_id").value = itemItem.id;
            document.getElementById("page_id_at_select").value =
                locItem.page.id;
            document.getElementById("column_id_select").value = itemItem.id;
        })
        .catch((error) =>
            console.error("Error loading image select form:", error)
        );
}

function CreateRowForm(modContent, location) {
    const locItem = JSON.parse(location);
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

function changePageTitle(location, divId) {
    const locItem = JSON.parse(location);
    var titleDiv = document.getElementById(divId);
    fetch("/title_change")
        .then((response) => response.text())
        .then((html) => {
            titleDiv.innerHTML = html;
            document.getElementById("page_title").value = locItem.page.title;
            document.getElementById("page_id").value = locItem.page.id;
        })
        .catch((error) => console.error("Error loading newNavSelect:", error));
}

const csrfToken = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");


var resizeTimeout;

function handleResize() {
    console.log("Window size changed!");
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(function () {
        console.log("Resizing stopped. Calling updateScreenSettings...");
        updateScreenSettings();
    }, 200);
}

function updateScreenSettings() {
    var path = scriptAsset + "session_mgr.php";
    var xhr = new XMLHttpRequest();
    xhr.open("POST", path, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                if (currentRoute) {
                    var newLoc = currentRoute + "_" + window.scrollY;
                    window.location.href = "/" + newLoc;
                }
            } else {
                console.log("Error setting session variable");
            }
        }
    };

    var width = window.innerWidth;

    var data = "action=refreshScreen" + "&width=" + width;
    xhr.send(data);
}

var currentRoute;
function setSessionScreenSize2() {
    var pathtophp = scriptAsset + "session_mgr.php";
    console.log(pathtophp);
    var xhr = new XMLHttpRequest();
    xhr.open("POST", scriptAsset + "session_mgr.php?action=setMobile", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    var postData = "width=" + window.innerWidth;
    xhr.send(postData);
}

function setEditMode(toggle) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "editMode.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    var postData = "editMode =" + toggle;
    xhr.send(postData);
}

var tooltipTimeout;

function showTooltip(tooltipId) {
    var tooltip = document.getElementById(tooltipId);
    if (tooltip) {
        tooltip.style.display = "block";
        clearTimeout(tooltipTimeout);
    }
}

function hideTooltip(tooltipId) {
    tooltipTimeout = setTimeout(function () {
        var tooltip = document.getElementById(tooltipId);
        if (tooltip) {
            tooltip.style.display = "none";
        }
    }, 10);
}

function toolTipStart() {
    for (let i = 0; i < 6; i++) {
        var element = document.getElementById("trash_icon_" + i);
        element.addEventListener("mouseover", function () {
            showTooltip("tooltip_trash" + i);
        });
        element.addEventListener("mouseout", function () {
            hideTooltip("tooltip_trash" + i);
        });
        var element = document.getElementById("file_icon_" + i);
        element.addEventListener("mouseover", function () {
            showTooltip("tooltip_file" + i);
        });
        element.addEventListener("mouseout", function () {
            hideTooltip("tooltip_file" + i);
        });
        var element = document.getElementById("upload_icon_" + i);
        element.addEventListener("mouseover", function () {
            showTooltip("tooltip_upload" + i);
        });
        element.addEventListener("mouseout", function () {
            hideTooltip("tooltip_upload" + i);
        });
    }
}
