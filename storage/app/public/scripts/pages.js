function pageFormRouter(formName, jItem) {
    var item = JSON.parse(jItem);
    originalPageTitle = item.title;
    var form = document.getElementById(formName);
    form.addEventListener("submit", function (event) {
        event.preventDefault();
    });
    var title = document.getElementById(formName + "_title");

    title.addEventListener("input", function (event) {
        validatePageTitle(title);
    });
    addFieldAndValue(formName + "_title", item.title);

    addFieldAndValue("page_id", item.id);
    var blueDiv = document.getElementById("page_title_click");
    blueDiv.classList.remove("blue_row");
    blueDiv.classList.add("blue-flat");
}
var originalPageTitle;

function validatePageTitle(text) {
    var title = text.value;
    var message = document.getElementById("no_duplicates");
    var btn = document.getElementById("edit_title_page_btn");
    if (title.trim() === "") {
        text.style.backgroundColor = "rgb(241, 78, 78)";
        text.placeholder = "页面标题不能为空";
        btn.classList.add("disabled");
    }
    else if (duplicatePageName(title)) {
        if (title != originalPageTitle) {
            text.style.backgroundColor = "rgb(241, 78, 78)";
            text.placeholder = "";
            message.style.display="block";
            btn.classList.add("disabled");
        }
    }
    else{
        text.style.backgroundColor = "";
        text.placeholder = "";
        message.style.display="none";
    }
}

function duplicatePageName(title) {
    return allRoutes.some((route) => {
        if (title.trim() === route) {
            return true;
        }
    });
}
