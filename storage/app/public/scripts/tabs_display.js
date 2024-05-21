var tabTracker;

function setTabMenuScroll(id) {
    var scroll = document.getElementById("scroll_" + id);
    var content = document.getElementById("content_" + id);
    var menu = document.getElementById("menu_" + id);
    var rect = element.getBoundingClientRect();
    var rect = element.getBoundingClientRect();
    var scrollTop = rect.top;
    var scrollBottom = rect.bottom;
}

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

function changeTab(rowId, anchorId, tabIndex, fromClick) {
    const row = document.getElementById(rowId);
    var uls = row.querySelectorAll("#tabs");
    var ulElement = uls[0]; // Access the first <ul> element directly
    var links = ulElement.querySelectorAll("a");
    links.forEach(function (link) {
        link.className = "tab-item-off";
    });
    var link = document.getElementById(anchorId);

    link.className = "tab-item-on";
    var contentBox = "tabContent_" + rowId;
    var contentDivs = document.querySelectorAll("." + contentBox);
    console.log(contentDivs.length + " is how many divs we got");
    let displayedPage;

    // Promise that resolves when styles are changed

    contentDivs.forEach((page) => {
        page.style.display = "none";
        if (page.id === "contents" + tabIndex) {
            console.log('found page at '+page.id);
            page.style.display = "block";
            displayedPage = page; // Save the displayed page
        } else {
         page.style.display = "none";
        }
    });

    if (fromClick) {

        var desiredOffset = displayedPage.getBoundingClientRect().top - headSpace; // Calculate desired offset
        var scrollToOffset = window.scrollY + desiredOffset; 
        window.scrollTo({
            top: scrollToOffset,
            behavior: "smooth"
        });

    }
}

function populateRoutesNoTab(pageId,rowId, tabIndex, tabId) {
    const row = document.getElementById(rowId);
    const selectRoutes = row.querySelectorAll("#select_" + rowId + tabId);
    const routeSelect = selectRoutes[0];
    const routeValues = row.querySelectorAll("#save_" + rowId + tabId);
    const useRoute = routeValues[0];
    const replaceDivs = row.querySelectorAll(".tabContent_" + rowId);
    const div = replaceDivs[0];
    console.log("how many : " + replaceDivs.length);
    allRoutes.forEach(function (page) {
        var option = document.createElement("option");
        option.value = page;
        option.text = page;
        routeSelect.appendChild(option);
    });
    var formName = "form_asign_tab" + rowId + tabId;
    var form = document.getElementById(formName);

    form.addEventListener("submit", function (event) {
        event.preventDefault();
    });
    routeSelect.addEventListener("change", function (event) {
        console.log('ACTION');
        useRoute.value = routeSelect.value;
        var renderDiv = document.getElementById('rowInsert'+rowId);
        var sequence = "tab_menu^" + rowId + "^"+pageId;
        writeAndRender(formName,sequence,renderDiv)
       
    });
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
