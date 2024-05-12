var tabTracker;

function setTabMenuScroll(id)
{
var scroll = document.getElementById('scroll_'+id);
var content = document.getElementById('content_'+id)
var menu = document.getElementById('menu_'+id)
var rect = element.getBoundingClientRect();
var rect = element.getBoundingClientRect();
var scrollTop = rect.top;
var scrollBottom = rect.bottom;

}
// window.addEventListener("scroll", function() {
//     const dummyDiv = document.getElementById("dummy-div");
//     const menu = document.getElementById("menu");
//     const scrollY = window.scrollY;

//     // Adjust the height of the dummy div based on the scroll position
//     dummyDiv.style.height = menu.clientHeight + "px";
// });

// window.addEventListener("scroll", function() {
//     var dummy = document.getElementById("dummy");
//     var menuContainer = document.getElementById("menu-container");
//     var menu = document.getElementById("menu");
//     var scrollPosition = window.scrollY;
//     var dummyHeight = menu.offsetHeight;
//     if (scrollPosition >= dummyHeight) {
//         menuContainer.classList.add("fixed");
//     } else {
//         menuContainer.classList.remove("fixed");
//     }
//     dummy.style.height = menu.offsetHeight + "px";
// });

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


function changeTab(rowId, anchorId, tabIndex, tabId) {
    preventScrolling();
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
    var sequence = "tab_refresh^"+rowId +"^"+tabIndex+"^"+tabId;
    renderToDiv(content, sequence)
    .then(() => {
        loadNoRoutes();
        enableScrolling();
    })
    .catch((error) => {
        console.error('Error refreshing page:', error);
    });

}




function populateRoutesNoTab(rowId,tabIndex, tabId) {
    const row = document.getElementById(rowId);
    const selectRoutes = row.querySelectorAll("#select_" + rowId + tabId);
    const routeSelect = selectRoutes[0];
    const routeValues = row.querySelectorAll("#save_" + rowId + tabId);
    const useRoute = routeValues[0];
    const replaceDivs = row.querySelectorAll('.tabContent_'+rowId);
    const div = replaceDivs[0];
    console.log('how many : '+ replaceDivs.length)
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
       
    });
    routeSelect.addEventListener("change", function (event) {
        useRoute.value = routeSelect.value;
        submitUpdateRequest_tab(formName,div, rowId, tabIndex,tabId);
    });

}

function submitUpdateRequest_tab(formName, div, rowId, tabIndex, tabId) {

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
                fetch("refresh_/tab_refresh^"+rowId +"^"+tabIndex+"^"+tabId)
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