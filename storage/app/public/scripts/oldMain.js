var imagesAsset;
var iconsAsset;
var fontsAsset;
var scriptAsset;
var allRoutes;
var resizeTimeout;
var allImages;
var scrollBackTo;
var locItem;
var modBody;
var modTitleLabel;

function decodeRoutes(encodedString) {
    var decodedString = encodedString.replace(/&quot;/g, '"');
    var array = JSON.parse(decodedString);
    return array;
}

//  add scroll to into this. after we get tabs working again.
// function loadPage(route) {
//     console.log("load at LOADER: " + route);
//     fetch("/load_page/" + route)
//         .then((response) => response.text()) // Parse response as text
//         .then((html) => {
//             document.getElementById("main_content").innerHTML = html;
//             executeScriptsInContent();
//         })
//         .catch((error) => console.error("Error loading page:", error));
// }
// function executeScriptsInContent() {
//     var runScripts = document.querySelectorAll("#runScript");
//     runScripts.forEach((script) => {
//         var innerHtml = script.innerHTML;
//         var loadTabCall = innerHtml.match(/startTabs\([^)]*\)/);
//         if (loadTabCall !== null) {
//             eval(loadTabCall[0]);
//         }
//     });
//     console.log('ran scripts ');
// }

// function openMainModal(action, item, location, modalSize) {
//     scrollBackTo = window.scrollY;
//     locItem = JSON.parse(location);
//     preventScrolling();
//     set_rescroll();
//     var dialogElement = document.getElementById("main_modal_dialog");
//     dialogElement.className = "modal-dialog " + modalSize;
//     $("#main_modal").modal("show");
//     modBody = document.getElementById("main_modal_body");
//     modTitleLabel = document.getElementById("main_modal_label");

//     if (action.includes("nav")) {
//         var parts = action.split("?");
//         modalContentNav(parts[1], item);
//     } else if (action === "removeItem") {
//         removeNavWarning(item);
//     } else if (action === "removeRow") {
//         removeRowWarning();
//     } else if (action === "uploadImage") {
//         showUploadImageStandard(item);
//     } else if (action === "createRow") {
//         insertCreateRowForm(item);
//     } else if (action === "editSlideshow") {
//         editSlidesForm(item);
//     } else if (action === "editTabs") {
//         editTabsForm(item);
//     } else if (action === "deletePage") {
//         deletePageWarning(item);
//     }
// }

// function insertCreateRowForm() {
//     document.getElementById("main_modal_label").innerHTML =
//         "选择要创建的行类型";
//     if (!locItem.row) {
//         locItem.row = { id: 0, index: 0 };
//     }
//     fetch("/row_type")
//         .then((response) => response.text())
//         .then((html) => {
//             modBody.innerHTML = html;
//             document.getElementById("page_id_slide").value = locItem.page.id;
//             document.getElementById("row_index_slide").value =
//                 locItem.row.index;
//             document.getElementById("slide_scroll_to").value = scrollBackTo;
//             document.getElementById("page_id_1col").value = locItem.page.id;
//             document.getElementById("row_index_1col").value = locItem.row.index;
//             document.getElementById("2col_scroll_to").value = scrollBackTo;
//             document.getElementById("page_id_2col").value = locItem.page.id;
//             document.getElementById("row_index_2col").value = locItem.row.index;
//             document.getElementById("1col_scroll_to").value = scrollBackTo;
//             document.getElementById("page_id_tab").value = locItem.page.id;
//             document.getElementById("row_index_tab").value = locItem.row.index;
//             document.getElementById("tab_scroll_to").value = scrollBackTo;
//             document.getElementById("page_id_left").value = locItem.page.id;
//             document.getElementById("row_index_left").value = locItem.row.index;
//             document.getElementById("left_scroll_to").value = scrollBackTo;
//             document.getElementById("page_id_right").value = locItem.page.id;
//             document.getElementById("row_index_right").value =
//                 locItem.row.index;
//             document.getElementById("right_scroll_to").value = scrollBackTo;
//         })
//         .catch((error) => console.error("Error loading newNavSelect:", error));
// }

// function preventScrolling() {
//     var scrollTop = window.scrollY || document.documentElement.scrollTop;
//     document.body.style.position = "fixed";
//     document.body.style.top = `-${scrollTop}px`;
//     document.body.style.width = "100%";
// }
// function enableScrolling() {
//     var scrollTop = parseInt(document.body.style.top, 10);
//     document.body.style.position = "";
//     document.body.style.top = "";
//     document.body.style.width = "";
//     window.scrollTo(0, -scrollTop);
// }

// function set_rescroll() {
//     var closeButton = document.getElementById("close_main_modal");
//     closeButton.addEventListener("click", function () {
//         enableScrolling();
//     });
// }
var currentScreen;
function handleResize(route) {

    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(function () {
        if (Math.abs(window.innerWidth - currentScreen) > 15) {
            window.location.href =
                "/session/screen?" +
                window.innerWidth +
                "?" +
                route +
                "?" +
                window.scrollY;
        }
    }, 50);
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
