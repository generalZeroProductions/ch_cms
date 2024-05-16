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
    window.location.href = "/session/view?" + route;
}
function dashboardReturn() {
    window.location.href = "/session/endbuild";
}
function setEditMode(toggle, route) {
    scrollDiv = findClosestDiv();
    window.location.href =
        "/session/edit?" + toggle + "?" + route +"?"+scrollDiv
}

function findClosestDiv() {
    var rowMarks = document.querySelectorAll('.row_mark');
    let closestDiv = null;
    let closestDistance = Infinity;
    rowMarks.forEach((div) => {
        const distance = Math.abs(div.getBoundingClientRect().top - headSpace);
        if (distance < closestDistance) {
            closestDiv = div;
            closestDistance = distance;
        }
    });
    return closestDiv.id;
}


var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

function enterPageBuild(route, from, tabId) {
    if (from === "build") {
        setScrollTo(0);
        var match = window.location.href.match(/\/([^\/?]+)(?:\?.*)?$/);
        from =  match ? match[1] : null;
    }
    if (tabId) {
        updateTabId(tabId);
    }
    window.location.href =
        "/session/build?" + route + "?" + from
}

function removeRowWarning(jItem) {
    
    item = JSON.parse(jItem);
    document.getElementById("main_modal_label").innerHTML = "确认删除此行 ";
    fetch("/delete_row_form")
        .then((response) => response.text())
        .then((html) => {
            modBody.innerHTML = html;
            document.getElementById("row_id").value = item.row.id;
            document.getElementById("page_id").value = item.page.id;
            document.getElementById("scroll_to").value = item.page.id;
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