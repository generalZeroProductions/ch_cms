var tabTracker;

// $tabCol = 'tab_col_' . $rowId;
// $scrollTabs = 'scroll_' . $rowId;
// $contentCol = 'content_col_' . $rowId;
// $contentDiv = 'content_div_' . $rowId;

// function loadTab(tab, rowId) {
//     preventScrolling();
//     const tabItem = JSON.parse(tab);
//     tabTracker = tabItem.id + "T" + rowId;
//     const linkId = "tab_" + tabItem.id;
//     const content = document.getElementById("content_div_" + rowId);
//     const scrollTabs = document.getElementById("scroll_" + rowId);

//     updateTabId(tabTracker);
//     fetch("/load_tab/" + tabItem.route)
//         .then((response) => response.text()) // Parse response as text
//         .then((html) => {
//             content.innerHTML = html;
//             if (tabItem.route === "no_tab_assigned") {
//                 var tabLabel = content.querySelector("#no-tab-content");
//                 const scrollTo = document.getElementById("tab_scroll_to");
//                 window.addEventListener("scroll", function () {
//                     scrollTo.value = window.scrollY;
//                 });
//                 tabLabel.innerHTML = tabItem.title;
//                 executeScriptsInTab(tabItem.id);
//             }
//             enableScrolling();
//         })
//         .catch((error) => console.error("Error loading page:", error));
//     console.log("SCROLL IS: " + scroll);
//     return;
//     highlightListItem(scrollTabs, linkId);
// }

// function startTabs(title, route, linkId, tabId, rowId) {
//     console.log("row id????" + rowId);
//     const content = document.getElementById("content_div_" + rowId);
//     const scrollTabs = document.getElementById("scroll_" + rowId);
//     updateTabId(tabId + "T" + rowId);
//     fetch("/load_tab/" + route)
//         .then((response) => response.text()) // Parse response as text
//         .then((html) => {
//             content.innerHTML = html;
//             if (route === "no_tab_assigned") {
//                 var tabLabel = content.querySelector("#no-tab-content");
//                 const scrollTo = document.getElementById("tab_scroll_to");
//                 window.addEventListener("scroll", function () {
//                     scrollTo.value = window.scrollY;
//                 });
//                 tabLabel.innerHTML = title;
//                 executeScriptsInTab(tabId);
//             }
//         })
//         .catch((error) => console.error("Error loading page:", error));

//     highlightListItem(scrollTabs, linkId);
// }  <div id="{{ $contentId . $i }}" class="tabContent_{{$rowId}}">'content_' . $rowId;

function changeTab(rowId, anchorId, tabIndex) {
    const row = document.getElementById(rowId); 
    var uls = row.querySelectorAll("#tabs");
    var ulElement = uls[0]; // Access the first <ul> element directly
    var links = ulElement.querySelectorAll("a");
    links.forEach(function (link) {
        link.className = "tab-item-off";
    });
    var link = document.getElementById(anchorId);

    link.className = "tab-item-on";
    var contentBox = 'content_'+rowId;
    const content = document.getElementById(contentBox);
    var sequence = "refresh_/tab_refresh^"+rowId +"^"+tabIndex;
    refreshDiv(content, sequence)

}

// function refreshDiv(div, sequence) {

function tabsScrollWithContent(menuId, contentId) {
    window.addEventListener("scroll", function () {
        var menu = document.getElementById(menuId);
        var navBar = document.getElementById("main_navigtion");
        var contentDiv = document.getElementById(contentId);
        var contentRect = contentDiv.getBoundingClientRect();
        var contentHeight = contentRect.height;
        var contentBottom = contentRect.bottom;
        var contentTop = contentRect.top;
        console.log("bottom of content: " + contentBottom);
    });
}

// function executeScriptsInTab(tabId) {
//     var runScriptsTab = document.querySelectorAll("#runScriptTab");
//     runScriptsTab.forEach((script) => {
//         var innerHtml = script.innerHTML;
//         innerHtml = innerHtml.replace(
//             /populateRoutesNoTab\(([^)]*)\)/,
//             `populateRoutesNoTab(${tabId})`
//         );
//         var setRoutesCall = innerHtml.match(/populateRoutesNoTab\([^)]*\)/);
//         if (setRoutesCall !== null) {
//             eval(setRoutesCall[0]);
//         }
//     });
// }

// function populateRoutesNoTab(tabId) {
//     const selectRoutes = document.getElementById("no_tab_route_select");
//     if (selectRoutes) {
//         console.log(allRoutes + "ALL ");
//         allRoutes.forEach(function (page) {
//             var option = document.createElement("option");
//             option.value = page;
//             option.text = page;
//             selectRoutes.appendChild(option);
//         });
//         var selectElement = document.getElementById("no_tab_route_select");
//         document.getElementById("tab_scroll_to").value = window.scrollY;
//         document.getElementById("quick_tab_id").value = tabId;
//         var routeSelect = document.getElementById("route");
//         var form = document.getElementById("tab_quick_select"); // Replace "your_form_id" with the actual ID of your form
//         selectElement.addEventListener("change", function () {
//             routeSelect.value = selectElement.value;
//             form.submit();
//         });
//     }
// }

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

function populateRoutesNoTab(rowId, tabId) {
    const row = document.getElementById(rowId);
    const selectRoutes = row.querySelectorAll("#select_" + rowId + tabId);
    const routeSelect = selectRoutes[0];
    const routeValues = row.querySelectorAll("#save_" + rowId + tabId);
    const useRoute = routeValues[0];
    const replaceDivs = row.querySelectorAll('.tabContent_'+rowId+tabId);
    const div = replaceDivs[0];

    allRoutes.forEach(function (page) {
        var option = document.createElement("option");
        option.value = page;
        option.text = page;
        routeSelect.appendChild(option);
    });
    var formName = "form_asign_tab" + rowId + tabId;
    var form = document.getElementById(formName);
   
    form.addEventListener("submit", function(event) {
        event.preventDefault();
        submitUpdateRequest_tab(formName,div);
    });
    routeSelect.addEventListener("change", function (event) {
        useRoute.value = routeSelect.value;
       form.submit();
    });

}

function submitUpdateRequest_tab(formName, div) {
    preventScrolling();
    var form = document.getElementById(formName);
    const formData = new FormData(form);
    fetch("/write_tab", {
        method: "POST",
        body: formData,
    })
        .then((response) => {
            if (response.ok) {
                console.error("Form submitte OK:", response.statusText);
                fetch("/refresh_tab/" + formName + "^" + tabId)
                    .then((response) => response.text()) // Parse response as text
                    .then((html) => {
                        div.innerHTML = html;
                        enableScrolling();
                    })
                    .catch((error) => {
                        console.error("Error fetching updated data:", error);
                        enableScrolling();
                    });
            } else {
                console.error("Form submission failed:", response.statusText);
                enableScrolling();
            }
        })
        .catch((error) => {
            console.error("Error writing to " + formName + ":", error);
            enableScrolling();
        });
}
