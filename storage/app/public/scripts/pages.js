var modBody;
var modTitleLabel;
// var refreshInline = false;
var headSpace = 0;

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
    blueDiv.onclick = null;
    var title = document.getElementById(formName + "_title");
    title.addEventListener("focus", function (event) {
        function handleKeyDown(event) {
            if (event.key === "Enter") {
                if (verifySubmit(btn)) {
                    writeAndReturn(formName, title.value);
                }
            }
            if (event.key === "Backspace") {
                validatePageTitle(title, btn);
            }
        }
        document.addEventListener("keydown", handleKeyDown);
    });
    title.addEventListener("blur", function (event) {
        document.removeEventListener("keydown", handleKeyDown);
    });
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
    } else if (!isValidRoute(title.trim())) {
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
        btn.classList.remove("disabled");
    }
}

function isValidRoute(text) {
    const pattern = /[\\%$#@!^*]|[\s]/;
    return !pattern.test(text);
}

function duplicatePageName(title) {
    return allRoutes.some((route) => {
        if (title.trim() === route) {
            return true;
        }
    });
}

function openMainModal(action, item, modalSize) {
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
    } else if (action === "deleteInquiry") {
        deleteInqWarning(item);
    } else if (action === "addUser") {
        addUser(item);
    } else if (action === "editUser") {
        editUser(item);
    } else if (action === "deleteUser") {
        deleteUser(item);
    }

    
}

function deleteInqWarning(item) {
    scrollBack =  window.scrollY
    document.getElementById("main_modal_label").innerHTML =
        "您确定要删除此查询吗";
    fetch("/delete_contact_form")
        .then((response) => response.text())
        .then((html) => {
            if (modBody) {
                modBody.innerHTML = html;
                var inqId = document.getElementById("inq_id");
                inqId.value = item;
                var scrollDash = document.getElementById("scrollDash");
                scrollDash.value = scrollBack;
            } else {
                console.log("NO MOD BODY");
            }
        })
        .catch((error) =>
            console.error("Error loading  delete Contact item:", error)
        );
}
function insertCreateRowForm(jItem) {
    document.getElementById("main_modal_label").innerHTML =
        "选择要创建的行类型";
    item = JSON.parse(jItem);
    if (!item.row) {
        item.row = { id: 0, index: 0 };
    }
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
            var scrolls = document.querySelectorAll(".rs_scroll");
            scrolls.forEach((element) => {
                element.value = item.row.index;
            });
        })
        .catch((error) => console.error("Error loading newNavSelect:", error));
}

function deletePageWarning(item) {
    document.getElementById("main_modal_label").innerHTML = "确认删除页面";
    fetch("/delete_page_form")
        .then((response) => response.text())
        .then((html) => {
            if (modBody) {
                modBody.innerHTML = html;
                document.getElementById("page_id").value = item;
            }
        })
        .catch((error) =>
            console.error("Error loading remove nav item:", error)
        );
}
