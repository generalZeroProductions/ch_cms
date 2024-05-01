var tabData = [];
var tabIndex;
var newTabId;

function startTabs(title, route, ul, link, div, tabId) {
    console.log(tabId + " this was tab Id");
    const content = document.getElementById(div);
        fetch("/load_tab/"+route)
            .then((response) => response.text()) // Parse response as text
            .then((html) => {
                content.innerHTML = html;
                if(route ==='no_tab_assigned')
                {
                    var tabLabel = content.querySelector("#no-tab-content");
                    tabLabel.innerHTML = title;
                    executeScriptsInTab(tabId);
                }
            })
            .catch((error) => console.error("Error loading page:", error));
   
    highlightListItem(ul, link);
}
function populateRoutesNoTab(tabId)
{
    console.log("tab id came in as: "+tabId);
    const selectRoutes = document.getElementById('no_tab_route_select');
    allRoutes.forEach(function (page) {
        var option = document.createElement("option");
        option.value = page;
        option.text = page;
        selectRoutes.appendChild(option);
    });
   
        var selectElement = document.getElementById("no_tab_route_select");
        document.getElementById("tab_scroll_to").value= window.scrollY;
        document.getElementById("quick_tab_id").value = tabId;
        var routeSelect = document.getElementById("route");
        var form = document.getElementById("tab_quick_select"); // Replace "your_form_id" with the actual ID of your form
        selectElement.addEventListener("change", function() {
            routeSelect.value = selectElement.value;
            form.submit();
    
    });
    
}
function loadTab(tab, div, ulId, linkId) {
    preventScrolling();
    const tabItem = JSON.parse(tab);
    const content = document.getElementById(div);
        fetch("/load_tab/" + tabItem.route)
            .then((response) => response.text()) // Parse response as text
            .then((html) => {
                content.innerHTML = html;
                if(tabItem.route ==='no_tab_assigned')
                {
                    var tabLabel = content.querySelector("#no-tab-content");
                    tabLabel.innerHTML = tabItem.title;
                    executeScriptsInTab(tabItem.id);
                }
                enableScrolling();
            })
            .catch((error) => console.error("Error loading page:", error));
   
    highlightListItem(ulId, linkId);
}
function executeScriptsInContent() {

    var runScripts = document.querySelectorAll("#runScript");
    runScripts.forEach((script) => {
        var innerHtml = script.innerHTML;
        var loadTabCall = innerHtml.match(/startTabs\([^)]*\)/);
        if (loadTabCall !== null) {
            eval(loadTabCall[0]);
        }
    });
} 


function executeScriptsInTab(tabId) {
    var runScriptsTab = document.querySelectorAll("#runScriptTab");
    runScriptsTab.forEach((script) => {
        var innerHtml = script.innerHTML;
        innerHtml = innerHtml.replace(/populateRoutesNoTab\(([^)]*)\)/, `populateRoutesNoTab(${tabId})`);
        var setRoutesCall = innerHtml.match(/populateRoutesNoTab\([^)]*\)/);
        if (setRoutesCall !== null) {
            eval(setRoutesCall[0]);
        }
    });
}
function highlightListItem(ulId, linkId) {
    var ulElement = document.getElementById(ulId);
    var links = ulElement.querySelectorAll("a");

    links.forEach(function (link) {
        link.className = "tab-item-off";
    });
    var link = document.getElementById(linkId);
    if (link) {
        link.className = "tab-item-on";
    }
    var clickedTab = link.parentNode;
}

function loadTabAcc(tab, div) {
    const tabItem = JSON.parse(tab);
    const content = document.getElementById(div);
    if (tabItem.route != "no_tab_assigned") {
        fetch("/load-tab/" + tabItem.route)
            .then((response) => response.text()) // Parse response as text
            .then((html) => {
                content.innerHTML = html;
            })
            .catch((error) => console.error("Error loading page:", error));
    } else {
        var tabLabel = content.querySelector("#no-tab-content");
        tabLabel.innerHTML = tabItem.title;
    }
}

function decodeRoutes(encodedString) {
    var decodedString = encodedString.replace(/&quot;/g, '"');
    var array = JSON.parse(decodedString);
    return array;
}

function editTabsList(tabList, tabId,contentId, location) {
   scrollBackTo = window.scrollY;
    const contentDiv = document.getElementById(contentId);
    if (contentDiv) {
        contentDiv.className = "";
        contentDiv.classList.add("col-md-8");
    }
    else
    {
        console.log("CANT FIND CONENT");
    }
    const tabDiv = document.getElementById(tabId);
    if (tabDiv) {
        tabDiv.className = "";
        tabDiv.classList.add("col-md-4");
    }
    const locItem = JSON.parse(location);
    console.log(tabList);
    tabIndex = 1;
    newTabId = -1;
    fetch("/edit_tabs")
        .then((response) => response.text())
        .then((html) => {
            if (tabDiv) {
                tabDiv.innerHTML = html;
                var listDiv = document.getElementById("tab_list");
                document.getElementById("row_id").value = locItem.row.id;
                document.getElementById("page_id").value =locItem.page.id;
                    document.getElementById("scroll_to").value = window.scrollY;
                tabList.forEach(function (tab) {
                    newTabFromSource(tab, listDiv);
                    window.scrollTo(0,scrollBackTo);
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
        if (text != "select a page")
        {
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
    console.log("tab update made ");
}
