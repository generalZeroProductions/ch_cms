var tabData = [];
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

function editTabsList(formName, jItem) {
   
    var item = JSON.parse(jItem);
    
    const contentCol = document.getElementById("content_col_" + item.rowId);
    contentCol.className = "col-8";
    const tab_col = document.getElementById("tab_col_" + item.rowId);
    tab_col.className = "col-4";
  
    var form = document.getElementById(formName);
    var lists = form.querySelectorAll("#tab_list");
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
        id: newNavId,
        title: "newTab",
        route: allRoutes[0],
        index: subNavIndex,
    };
    subNavIndex += 1;
    newNavId -= 1;
    addTab(newItem, list);
}
function newTabFromSource(tab, listDiv) {
    var newTab = {
        id: tab.id,
        title: tab.title,
        route: tab.route,
        index: tab.index,
    };
    addTab(newTab, listDiv);
}

function addTab(newTab, listDiv) {
    tabData.push(newTab);
    var newDiv = document.createElement("div");
    newDiv.classList.add("row");
    newDiv.classList.add("tab_li_spacer");
    var newInput = document.createElement("input");
    newInput.setAttribute("type", "text");
    newInput.id = "text_" + newTab.id;
    newInput.value = newTab.title;
    newDiv.appendChild(newInput);
    listDiv.appendChild(newDiv);
    var img = document.createElement("img");
    img.classList.add("link_icon_spacer");
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
        var text = event.target.value;
        var itemId = newTab.id;
        if (text != "select a page") {
            updateTab(itemId, { title: text });
        }
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
    hiddenField.value = JSON.stringify(tabData);
}
