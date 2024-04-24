var tabData = [];
var tabIndex;
var newTabId;

function loadTab(tabId, routeName, ulId, linkId) {
    console.log(tabId);
    fetch("/load-tab/" + routeName)
        .then((response) => response.text()) // Parse response as text
        .then((html) => {
            document.getElementById(tabId).innerHTML = html;
        })
        .catch((error) => console.error("Error loading page:", error));
    highlightListItem(ulId, linkId);
}

function loadVertTab(tabId, routeName) {
    fetch("/load-tab/" + routeName)
        .then((response) => response.text()) // Parse response as text
        .then((html) => {
            document.getElementById(tabId).innerHTML = html;
        })
        .catch((error) => console.error("Error loading page:", error));
}

function decodeRoutes(encodedString) {
    var decodedString = encodedString.replace(/&quot;/g, '"');
    var array = JSON.parse(decodedString);
    return array;
}

function editTabsList(tabList, tabDiv, location) {
    const divID = document.getElementById(tabDiv);  
    const locItem = JSON.parse(location); 
   console.log(tabList);
    tabIndex = 1;
    newTabId = -1;
    fetch('/edit_tabs')
        .then((response) => response.text())
        .then((html) => {
            if (divID) {
                divID.innerHTML = html;
                var listDiv = document.getElementById("tab_list");
                var rowDiv = document.getElementById("row_id").value = locItem.row.id;
                var pageid = document.getElementById("page_id").value = locItem.page.id;
                tabList.forEach(function (tab) {
                    newTabFromSource(tab, listDiv);
                });
            }
        })
        .catch((error) => console.error("Error loading newNavSelect:", error));
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
    addTab(newItem,list);
}
function newTabFromSource(tab, listDiv) {
    var newTab = {
        id: tab.id,
        title: tab.title,
        route: tab.route,
        index: tab.index,
    };
    addTab(newTab,listDiv);
}

function addTab(newTab,listDiv) {
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
    img.src = iconsAsset+"link.svg";
    newDiv.appendChild(img);
    var newSelect = document.createElement("select");
    newSelect.classList.add("form-control", "col");
    newSelect.id = "select_" + newTab.id;
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
        updateTab(itemId, { title: text });
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
    var hiddenField = document.getElementById("tabData"); // Assuming 'data' is the ID of the hidden field
    hiddenField.value = JSON.stringify(tabData); // Convert the object to a JSON string and set it as the value of the hidden field
    console.log("tab update made ");
}

function menuFolder(routes) {
    const menuItems = document.querySelectorAll('.menuFold');
    const tabRoutes = decodeRoutes(routes);
    menuItems.forEach((item,index) => {
        const menuItem = item.querySelector('.menu-item');
        const hiddenContent = item.querySelector('.hidden-content');
        const route = tabRoutes[index]; 
        fetch("/load-tab/" + route)
            .then(response => response.text()) // Parse response as text
            .then(html => {
                hiddenContent.innerHTML = html;
            })
            .catch(error => console.error("Error loading page:", error));
        menuItem.addEventListener('click', function() {
            console.log("clicked");
            // Toggle visibility of hidden content
            if (hiddenContent.style.display === 'block') {
                hiddenContent.style.display = 'none';
            } else {
                // Hide other hidden contents
                document.querySelectorAll('.hidden-content').forEach(content => {
                    if (content !== hiddenContent && content.style.display === 'block') {
                        content.style.display = 'none';
                    }
                });
                hiddenContent.style.display = 'block';
            }
        });
    });
}

function highlightListItem(ulId, linkId) {
    // Get the <ul> element
    var ulElement = document.getElementById(ulId);
   
    console.log("highlight link id " + linkId);
    
    // Get all <a> elements inside the <ul>
    var linkElements = ulElement.getElementsByTagName("a");

    // Loop through each <a> element
    for (var i = 0; i < linkElements.length; i++) {
        // If the current <a> element has the specified id, set its color to blue
        if (linkElements[i].id === linkId) {
            linkElements[i].style.color = "blue";
        } else {
            // Otherwise, set its color to black
            linkElements[i].style.color = "black";
        }
    }
}