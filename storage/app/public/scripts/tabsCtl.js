var tabData = [];
var tabIndex;
var newTabId
function editDropdown(tabList,  allTitles) {
    tabData = [];
    var allTabs = JSON.parse(tabList);
    const url = "/open_base_modal";
    var modContent;
    var pageTitles = JSON.parse(allTitles);
    tabIndex = 1;
    newTabId = -1;
    fetch(url)
        .then((response) => response.text())
        .then((html) => {
            var modalContainer = document.createElement("div");
            modalContainer.innerHTML = html;
            document.body.appendChild(modalContainer);
            var modal = document.getElementById("baseModal");
            modal.classList.add("show");
            modal.style.display = "block";
            modal.dataset.allTitles = allTitles;
            modContent = document.getElementById("base-modal-content");
            if (modContent) {
                const surl = "/tab_editor";
                fetch(surl)
                    .then((response) => response.text())
                    .then((html) => {
                        modContent.innerHTML = html;
                        var list = document.getElementById("tab_list");
                        allTabs.forEach(function (tab) {
                            newTabFromSource(
                                tab,
                                pageTitles,
                                modContent,
                                list
                            );
                        });
                    })
                    .catch((error) =>
                        console.error("Error loading newNavSelect:", error)
                    );
            }
        })
        .catch((error) => {
            // Handle errors
            console.error("Error:", error);
        });
}



function newTabFromSource(tab, pageTitles, modContent, list) {
    var newTab = {
        id: tab.id,
        title: tab.title,
        route: tab.route,
        index: tab.index,
    };
    addTab(newTab, pageTitles, modContent, list);
}

function addTab(newTab, pageTitles, modContent, list) {
    tabData.push(newTab);
    var newDiv = document.createElement("div");
    newDiv.classList.add("row");
    var newInput = document.createElement("input");
    newInput.setAttribute("type", "text");
    newInput.id = "text_" + newTab.id;
    newInput.value = newTab.title;
    newDiv.appendChild(newInput);
    modContent.appendChild(newDiv);
    var img = document.createElement("img");
    img.classList.add("link_icon_spacer");
    img.src = linkImagePath;
    newDiv.appendChild(img);
    var newSelect = document.createElement("select");
    newSelect.classList.add("form-control", "col");
    newSelect.id = "select_" + newTab.id;
    pageTitles.forEach(function (page) {
        var option = document.createElement("option");
        option.value = page;
        option.text = page;
        if (page === newItem.route) {
            option.selected = true; // Set 'selected' attribute for the default value
        }
        newSelect.appendChild(option);
    });
    newDiv.appendChild(newSelect);
    list.appendChild(newDiv);
    newSelect.addEventListener("change", function (event) {
        var selection = event.target.value;
        var itemId = newItem.id;
        updateItem(itemId, { route: selection });
    });

    newInput.addEventListener("input", function (event) {
        var text = event.target.value;
        var itemId = newItem.id;
        updateItem(itemId, { title: text });
    });
    updateTabData();
}

function updateItem(tabId, newData) {
    var index = tabData.findIndex((item) => item.id === tabId);
    if (index !== -1) {
        tabData[index] = { ...tabData[index], ...newData };
    }
    updateTabData();
}


function updateTabData() {
    var hiddenField = document.getElementById("tabData"); // Assuming 'data' is the ID of the hidden field
    hiddenField.value = JSON.stringify(tabData); // Convert the object to a JSON string and set it as the value of the hidden field
    console.log("tab update made ");
}