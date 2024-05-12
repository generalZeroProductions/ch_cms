function paginatePages() {
    
    const pagesDiv = document.getElementById("pagesDiv");
    fetch("/display_all_pages")
        .then((response) => response.json()) // Parse response as JSON
        .then((data) => {
            pagesDiv.innerHTML = data.html;
        })
        .catch((error) => console.error("Error loading pages:", error));
}

function viewSite(route) {
    console.log("VIEW ROUTE:  " + route);
    window.location.href = "/session/view?" + route;
}
function dashboardReturn() {
    window.location.href = "/session/endbuild";
}
function setEditMode(toggle, route) {
    window.location.href =
        "/session/edit?" + toggle + "?" + route + "?" + window.scrollY;
}

// enterPageBuild('{{ $record->title }}',null,null,null) "enterPageBuild('{{ $record->title }}',null,null)"
function enterPageBuild(route, from, tabId) {
    if (from === "build") {
        var match = window.location.href.match(/\/([^\/?]+)(?:\?.*)?$/);
        from =  match ? match[1] : null;
    }
    if (tabId) {
        updateTabId(tabId);
    }
    window.location.href =
        "/session/build?" + route + "?" + from + "?" + window.scrollY;
}

function removeRowWarning() {
    document.getElementById("main_modal_label").innerHTML = "确认删除此行 ";
    fetch("/delete_row_form")
        .then((response) => response.text())
        .then((html) => {
            modBody.innerHTML = html;
            document.getElementById("row_id").value = locItem.row.id;
            document.getElementById("delete_btn").innerHTML = "删除";
            document.getElementById("page_id").value = locItem.page.id;
            document.getElementById("scroll_to").value = scrollBackTo;
        })
        .catch((error) =>
            console.error("Error loading remove nav item:", error)
        );
}

function deletePageWarning(item) {
    const parseItem = JSON.parse(item);
    console.log(parseItem);
    document.getElementById("main_modal_label").innerHTML = "确认删除页面";
    fetch("/delete_page_form")
        .then((response) => response.text())
        .then((html) => {
            modBody.innerHTML = html;
            document.getElementById("delete_btn").innerHTML = "删除";
            document.getElementById("page_id").value = parseItem.id;
            document.getElementById("scroll_to").value = scrollBackTo;
        })
        .catch((error) =>
            console.error("Error loading remove nav item:", error)
        );
}





function authOn() {
    fetch("/admin/on", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
    })
        .then((response) => {
            if (response.ok) {
                console.log("Authentication turned on successfully");
            } else {
                console.error("Failed to turn on authentication");
            }
        })
        .catch((error) => {
            console.error(
                "Error occurred while turning on authentication:",
                error
            );
        });
}

function authOff() {
    fetch("/admin/off", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
    })
        .then((response) => {
            if (response.ok) {
                console.log("Authentication turned off successfully");
            } else {
                console.error("Failed to turn off authentication");
            }
        })
        .catch((error) => {
            console.error(
                "Error occurred while turning off authentication:",
                error
            );
        });
}