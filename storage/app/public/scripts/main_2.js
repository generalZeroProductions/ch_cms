var imagesAsset;
var iconsAsset;
var fontsAsset;
var scriptAsset;
var allRoutes;
var resizeTimeout;
var allImages;
var locItem;
var modBody;
var modTitleLabel;
var refreshInline = false;

function renderPageContent(pageId) {
   
    var div = document.getElementById("page_content");
    var sequence = "page^" + pageId;
    renderToDiv(div, sequence)
        .then(() => {
           
            loadScripts();
        })
        .catch((error) => {
            console.error("Error refreshing page:", error);
        });
}


function insertForm(formName, item, divId) {
    console.log("INSERT FORM DIV ID: " + divId);
    preventScrolling();
    var div = document.getElementById(divId);
    fetch("/insert_/insert_form/" + formName, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
        },
    })
        .then((response) => response.text()) // Parse response as text
        .then((html) => {
            console.log("WHY HTEML LNO GOOD??" + div)
            div.innerHTML = html; // Set the HTML content to the div
            formRouter(formName, item);
        })
        .catch((error) => {
            console.error(
                "Error occurred while loading " + formName,
                +": " + error
            );
            enableScrolling();
        });
}
function clickDiv(){
    console.log("div clidked");
}

function renderToDiv(div, sequence, ) {
   
    return new Promise((resolve, reject) => {
        fetch("/render_/render_content/"+sequence)
            .then((response) => {
                if (!response.ok) {
                    throw new Error("response from render failed");
                }
                return response.text();
            })
            .then((html) => {
                div.innerHTML = html;
                resolve();
            })
            .catch((error) => {
                console.error("Error fetching updated data:", error);
                reject(error);
            });
    });
}



function writeAndRender( formName, sequence, div) {
    console.log("WRITING: " + formName);
    var form = document.getElementById(formName);
    if(!form)
    {
        console.log("noForm");
        return;
    }
    form.addEventListener('submit', function(event) {
        event.preventDefault();
    });
    preventScrolling();
    var formData = new FormData(form);
    fetch("/write_/write_form/", {
        method: "POST",
        body: formData,
    })
        .then((response) => {
            if (response.ok) {
                renderToDiv(div, sequence);
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



function loadScripts() {
    var runScripts = document.querySelectorAll(".run-scripts");
    runScripts.forEach((script) => {
        var innerHtml = script.innerHTML;
        var loadTabCall = innerHtml.match(/changeTab\([^)]*\)/);

        if (loadTabCall !== null) {
            eval(loadTabCall[0]);
        }
    });
}
function loadNoRoutes() {
    var noRoutesScripts = document.querySelectorAll(".no-route-scripts");
    noRoutesScripts.forEach((script) => {
        var innerHtml = script.innerHTML;
        var noRouteCall = innerHtml.match(/populateRoutesNoTab\([^)]*\)/);
        if (noRouteCall !== null) {
            console.log('RAN NO ROUTE CALL')
            eval(noRouteCall[0]);
        }
    });
}
function formRouter(formName, item) {
   
    if (formName.includes("nav")) {
        filloutNavForms(formName, item);
    }
    if (formName.includes("img")) {
        imageFormFillout(formName, item);
    }
    if(formName.includes("tab")){
        editTabsSetup(formName, item);
    }
    if(formName.includes("article")){
        articleFormRouter(formName, item);
    }
    if(formName.includes('page')){
        pageFormRouter(formName, item);
    }
}

function pageFormRouter(formName, jItem){
    var item = JSON.parse(jItem);
   
    var form = document.getElementById(formName);
    form.addEventListener("submit", function (event) {
        event.preventDefault();
    });
    var title = document.getElementById(formName+"_title");

    title.addEventListener("input", function (event) {
        validatePageTitle(formName, title, event);
    });
    addFieldAndValue(formName+"_title", item.title);

    addFieldAndValue("page_id", item.id);
    var blueDiv = document.getElementById("page_title_click");
    blueDiv.classList.remove("blue_row");
    blueDiv.classList.add("blue-flat");

}


function addFieldAndValue(fieldName, fieldValue) {
    var field = document.getElementById(fieldName);
    field.value = fieldValue;
}


function decodeRoutes(encodedString) {
    var decodedString = encodedString.replace(/&quot;/g, '"');
    var array = JSON.parse(decodedString);
    return array;
}