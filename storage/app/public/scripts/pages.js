function pageFormRouter(formName, jItem) {
    var item = JSON.parse(jItem);
    originalPageTitle = item.title;
    var form = document.getElementById(formName);
    form.addEventListener("submit", function (event) {
        event.preventDefault();
    });
    var blueDiv = document.getElementById("page_title_click");
    blueDiv.classList.remove("blue_row");
    blueDiv.classList.add("blue-flat");
    var title = document.getElementById(formName + "_title");
    var btn = document.getElementById("edit_title_page_btn");
    btn.onclick = function () {
        if (verifySubmit(btn)) {
            writeAndReturn(formName, title.value);
        }
    };
    title.addEventListener("input", function (event) {
        validatePageTitle(title, btn);
    });
    addFieldAndValue(formName + "_title", item.title);
    addFieldAndValue("page_id", item.id);
}
var originalPageTitle;

function validatePageTitle(text, btn) {
    var title = text.value;
    var message = document.getElementById("no_duplicates");

    if (title.trim() === "") {
        text.style.backgroundColor = "rgb(241, 78, 78)";
        text.placeholder = "页面标题不能为空";
        btn.classList.add("disabled");
    } else if (duplicatePageName(title)) {
        if (title != originalPageTitle) {
            text.style.backgroundColor = "rgb(241, 78, 78)";
            text.placeholder = "";
            message.style.display = "block";
            btn.classList.add("disabled");
        }
    } else {
        text.style.backgroundColor = "";
        text.placeholder = "";
        message.style.display = "none";
    }
}

function duplicatePageName(title) {
    return allRoutes.some((route) => {
        if (title.trim() === route) {
            return true;
        }
    });
}

function openMainModal(action, item, modalSize) {
    preventScrolling();
   // add listenr on close to enable scrolling;
    var dialogElement = document.getElementById("main_modal_dialog");
    dialogElement.className = "modal-dialog " + modalSize;
    $("#main_modal").modal("show");
    modBody = document.getElementById("main_modal_body");
    modTitleLabel = document.getElementById("main_modal_label");

    if (action === "removeRow") {
        removeRowWarning(item);
    } else if (action === "createRow") {
        insertCreateRowForm(item);
    } else if (action === "editSlideshow") {
        editSlidesForm(item);
    } else if (action === "deletePage") {
        deletePageWarning(item);
    }
}

function insertCreateRowForm(jItem) {

    var closeBtn = document.getElementById("close_main_modal");
    closeBtn.addEventListener('click', function(event) {
       enableScrolling();
    });
    
    document.getElementById("main_modal_label").innerHTML =
        "选择要创建的行类型";
    item = JSON.parse(jItem);
    
    if (!item.row) {
        item.row = { id: 0, index: 0 };
    }
    console.log("want an index? "+item.row.index);
    fetch("/row_type")
        .then((response) => response.text())
        .then((html) => {
            modBody.innerHTML = html;
            document.getElementById("page_id_slide").value = item.page.id;
            document.getElementById("row_index_slide").value = item.row.index;
            document.getElementById("page_id_1col").value = item.page.id;
            document.getElementById("row_index_1col").value = item.row.index;

            document.getElementById("page_id_2col").value = item.page.id;
            document.getElementById("row_index_2col").value = item.row.index;

            document.getElementById("page_id_tab").value = item.page.id;
            document.getElementById("row_index_tab").value = item.row.index;

            document.getElementById("page_id_left").value = item.page.id;
            document.getElementById("row_index_left").value = item.row.index;

            document.getElementById("page_id_right").value = item.page.id;
            document.getElementById("row_index_right").value = item.row.index;
            var scrolls = document.querySelectorAll('.rs_scroll');
            scrolls.forEach(element => {
                element.value = item.row.index;
            });
        })
        .catch((error) => console.error("Error loading newNavSelect:", error));
}

function deletePageWarning(item) {
    const parseItem = JSON.parse(item);
    document.getElementById("main_modal_label").innerHTML = "确认删除页面";
    fetch("/delete_page_form")
        .then((response) => response.text())
        .then((html) => {
            modBody.innerHTML = html;
            document.getElementById("delete_btn").innerHTML = "删除";
            document.getElementById("page_id").value = parseItem.id;
        })
        .catch((error) =>
            console.error("Error loading remove nav item:", error)
        );
}
