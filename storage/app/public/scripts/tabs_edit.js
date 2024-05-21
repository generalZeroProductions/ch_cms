var tabData = [];
var deletedTabs = [];
var tabIndex;
var newTabId;
var subNavIndex;

function updateTabId(tabId) {
    fetch("/tab/new/" + tabId, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken, // Add CSRF token to headers
        },
    })
        .then((response) => {
            if (response.ok) {
                console.log(response);
            } else {
                console.error("Failed to change tabId ");
            }
        })
        .catch((error) => {
            console.error(
                "Error occurred while turning on authentication:",
                error
            );
        });
}

function editTabsSetup(formName, jItem) {
    var item = JSON.parse(jItem);
    tabData = [];
    deletedTabs = [];
    var contentCol = document.getElementById("content_col_" + item.rowId);
    contentCol.className = "col-6";
    var tabCol = "tab_col_" + item.rowId;
    var div = document.getElementById(tabCol);
    div.className = "col-6";
    addFieldAndValue("row_id", item.rowId);
    var form = document.getElementById(formName);
    var lists = form.querySelectorAll("#tab_list");
    var btn = document.getElementById("edit_tabs_btn");
    var rowId = document.getElementById("row_id");
    rowId.value = item.rowId;
    var pageId = document.getElementById("page_id");
    pageId.value = item.pageId;
    if (!div) {
        console.log("div NOT FOUND");
    }
    var renderDiv = document.getElementById('rowInsert'+item.rowId);
    var sequence = "tab_menu^" + item.rowId + "^"+item.pageId;
    btn.onclick = function () {
        if (verifySubmit(btn)) {
            if(renderDiv)
            {
                console.log('got render Div');
            }
            else{
                console.log('no render DIV -- ITEM was '+ item.rowId);
            }
            writeAndRender(formName, sequence, renderDiv);
        }
    };
    subNavIndex = item.tabs.length;
    tabIndex = 1;
    newTabId = -1;
    var listDiv = lists[0];
    item.tabs.forEach(function (tab) {
        newTabFromSource(tab, listDiv);
    });
}

function createTabItem() {
    var list = document.getElementById("tab_list");
    var newItem = {
        id: null,
        title: "新选项卡" + tabData.length,
        route: "no_tab_assigned",
        index: tabData.length,
        trash: "newTab" + tabData.length,
    };
    addTab(newItem, list);
}
function newTabFromSource(tab, listDiv) {
    console.log("making_tab " + tab.title);
    var newTab = {
        id: tab.id,
        title: tab.title,
        route: tab.route,
        index: tab.index,
        trash: tab.title,
    };
    addTab(newTab, listDiv);
}
function deleteTab(index) {
    console.log("sent index " + index);
    var deleteTab = tabData[index];
    deletedTabs.push(deleteTab);
    updateData = JSON.stringify(deletedSlides);
    var deletedTabsField = document.getElementById("deleted_tabs");

    if (index !== -1) {
        tabData.splice(index, 1);
        tabData.forEach((item) => {
            if (item.index > index) {
                item.index--;
            }
        });
    }
    var divToRemove = document.getElementById("tab_div" + deleteTab.trash);
    divToRemove.remove();
    updateTabData();
}

function addTab(newTab, listDiv) {
    tabData.push(newTab);
    var newDiv = document.createElement("div");
    newDiv.id = "tab_div" + newTab.trash;
    newDiv.classList.add("row");
    newDiv.classList.add("tab_li_spacer");
    var deleteLink = document.createElement("a");

    deleteLink.onclick = function () {
        deleteTab(newTab.index);
    };
    deleteLink.classList.add("trashcan");
    var img1 = document.createElement("img");
    img1.classList.add("tab-trash-icon");
    img1.src = iconsAsset + "trash.svg";
    deleteLink.appendChild(img1);
    newDiv.appendChild(deleteLink);
    var newInput = document.createElement("input");
    newInput.setAttribute("type", "text");
    newInput.id = "text_" + newTab.id;
    newInput.value = newTab.title;
    newInput.classList.add("tab-title");
    newDiv.appendChild(newInput);
    listDiv.appendChild(newDiv);
    var img = document.createElement("img");
    img.classList.add("tab-link-icon");
    img.src = iconsAsset + "link.svg";
    newDiv.appendChild(img);
    var newSelect = document.createElement("select");
    newSelect.classList.add("form-control", "col");
    newSelect.id = "select_" + newTab.id;
    var defOption = document.createElement("option");
    defOption.value = "select a page";
    defOption.text = "select a page";
    newSelect.appendChild(defOption);
    allRoutes.forEach(function (page) {
        var option = document.createElement("option");
        option.value = page;
        option.text = page;
        if (page === newTab.route) {
            option.selected = true; // Set 'selected' attribute for the default value
        }
        newSelect.appendChild(option);
    });
    newDiv.appendChild(newSelect);
    listDiv.appendChild(newDiv);
    newSelect.addEventListener("change", function (event) {
        var selection = event.target.value;
        var itemId = newTab.id;
        updateTab(itemId, { route: selection });
    });

    newInput.addEventListener("input", function (event) {
        console.log("listened to input");
        validateTabTitle(newInput, event);
        var text = event.target.value;
        var itemId = newTab.id;
        if (text != "select a page") {
            updateTab(itemId, { title: text });
        }
        updateTabData();
    });
    updateTabData();
}

function updateTab(tabId, newData) {
    var index = tabData.findIndex((item) => item.id === tabId);
    if (index !== -1) {
        tabData[index] = { ...tabData[index], ...newData };
    }
    updateTabData();
}

function updateTabData() {
    var hiddenField = document.getElementById("tabData");
    var display = document.getElementById("dataUpdate");
    display.innerHTML = JSON.stringify(tabData);
    hiddenField.value = JSON.stringify(tabData);

    var trash = document.querySelectorAll(".trashcan");
    if (tabData.length === 1) {
        trash.forEach((element) => {
            element.style.visibility = "hidden";
        });
    } else {
        trash.forEach((element) => {
            element.style.visibility = "visible";
        });
    }
}
