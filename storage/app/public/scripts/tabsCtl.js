var tabData = [];
var tabIndex;
var newTabId;

function loadTab(tabId, routeName, ulId, linkId) {
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

function editTabsList(tabList, routeList, tabDiv, rowId, pageName) {
    const url = "/edit_tabs";
    const divID = document.getElementById(tabDiv);   
    tabIndex = 1;
    newTabId = -1;
    fetch(url)
        .then((response) => response.text())
        .then((html) => {
            if (divID) {
                divID.innerHTML = html;
                var listDiv = document.getElementById("tab_list");
                var rowDiv = document.getElementById("row_id").value = rowId;
                var pageDiv = document.getElementById("page_name").value = pageName;
                document.getElementById("route_list").value = JSON.stringify(routeList);
                tabList.forEach(function (tab) {
                    console.log("foreach");
                    newTabFromSource(tab, routeList, listDiv);
                });
            }
        })
        .catch((error) => console.error("Error loading newNavSelect:", error));
}
function createTabItem() {
    var list = document.getElementById("tab_list");
    var routeList = JSON.parse(document.getElementById("route_list").value);
    console.log(routeList);
    var newItem = {
        id: newNavId,
        title: "newTab",
        route: routeList[0],
        index: subNavIndex,
    };
    subNavIndex += 1;
    newNavId -= 1;
    addTab(newItem, routeList,list);
}
function newTabFromSource(tab, routes, listDiv) {
    var newTab = {
        id: tab.id,
        title: tab.title,
        route: tab.route,
        index: tab.index,
    };
    addTab(newTab, routes, listDiv);
}

function addTab(newTab, routes, listDiv) {
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
    img.src = linkImagePath;
    newDiv.appendChild(img);
    var newSelect = document.createElement("select");
    newSelect.classList.add("form-control", "col");
    newSelect.id = "select_" + newTab.id;
    routes.forEach(function (page) {
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
    const allRoutes = decodeRoutes(routes);
    menuItems.forEach((item,index) => {
        const menuItem = item.querySelector('.menu-item');
        const hiddenContent = item.querySelector('.hidden-content');
        const route = allRoutes[index]; 
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