function paginatePages(index) {
    const pagesDiv = document.getElementById("pagesDiv");
    fetchRecords("/display_all_pages/"+index,pagesDiv);
}

function paginateInquiries(index) {
    const inquiriesDiv = document.getElementById("inquiresDiv");
    fetchRecords("/display_all_inquiries/"+index,inquiriesDiv);
} 


function fetchRecords(url,div) {
    console.log('do we have a fetch')
    fetch(url)
        .then(response => response.json())
        .then(data => {
            div.innerHTML = data.html;
        })
        .catch(error => console.error('Error loading inquiries:', error));
}

function viewSite(route) {
    window.location.href = "/session/view?" + route;
}
function dashboardReturn() {
    window.location.href = "/session/endbuild";
}
function setEditMode(toggle) {
    scrollDiv = findClosestDiv();
    var pathname = window.location.pathname;
    var parts = pathname.split("/");
    var route = parts[parts.length - 1];
    window.location.href =
        "/session/edit?" + toggle + "?" + route + "?" + scrollDiv;
}

function findClosestDiv() {
    var rowMarks = document.querySelectorAll(".rowInsert");
    let closestDiv = null;
    let minVerticalDistance = Infinity;
    const verticalCenter = window.innerHeight / 2; // Calculate vertical center of the page

    rowMarks.forEach((div) => {
        const divRect = div.getBoundingClientRect();
        const divCenter = (divRect.top + divRect.bottom) / 2; // Calculate center of the bounding box

        const verticalDistance = Math.abs(divCenter - verticalCenter);
        if (verticalDistance < minVerticalDistance) {
            closestDiv = div;
            minVerticalDistance = verticalDistance;
        }
    });
    console.log(closestDiv.id);
    return closestDiv.id;
}

var csrfToken = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");

function enterPageBuild(page, sentBy, rowId) {
    var returnPage = page;
    if (sentBy === "build") {
        var pathname = window.location.pathname;
        var parts = pathname.split("/");
        returnPage = parts[parts.length - 1];
    }

    window.location.href =
        "/session/build?" + page + "?" + returnPage + "?" + rowId;
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
function markContactRead(id){
    formName = "mark_contact_read_"+id;
writeNoReturn(formName);

}
function showInquiry(id){
    var bodies = document.querySelectorAll('.contact-body')
    bodies.forEach(body => {
        body.style.display="none";
        if(body.id==='inq_display'+id){
            body.style.display="block";  
        }  
    });
    var image = document.getElementById("read_contact"+id);
    image.setAttribute("src", iconsAsset+'glasses_white.svg');
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
