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
var headSpace = 0;

function renderPageContent(pageId, scroller) {
    var div = document.getElementById("page_content");
    var sequence = "page^" + pageId;
    // Create a new promise
    var loadScriptsPromise = new Promise((resolve, reject) => {
        resolve();
    });

    renderToDiv(div, sequence, scroller)
        .then(() => {
            // Once rendering is complete, execute loadScripts() after resolving the new promise
            return loadScriptsPromise.then(() => {
                enableScrolling();
                loadScripts();
                loadNoRoutes();
                console.log("LOOK FOR ROW " + scroller);
                var row = document.getElementById(scroller);
                if (row) {
                    console.log(
                        "FOUND SCROLL- " + row.id + " headspace " + headSpace
                    );
                    var desiredOffset = row.getBoundingClientRect().top - headSpace; // Calculate desired offset
                    var scrollToOffset = window.scrollY + desiredOffset;
                    window.scrollTo({
                        top: scrollToOffset,
                        behavior: "smooth",
                    });
                }
            });
        })
        .then(() => {
          
        })
        .catch((error) => {
            console.error("Error refreshing page:", error);
        });
}

function renderToDiv(div, sequence) {
  preventScrolling();
    console.log("RENDER TO DIV CALL");
    return new Promise((resolve, reject) => {
        fetch("/render_/render_content/" + sequence)
            .then((response) => {
                if (!response.ok) {
                    throw new Error("response from render failed");
                }
                return response.text();
            })
            .then((html) => {
                div.innerHTML = html;
                enableScrolling();
                    var desiredOffset =
                        div.getBoundingClientRect().top - 100; // Calculate desired offset
                    var scrollToOffset = window.scrollY + desiredOffset;
                    window.scrollTo({
                        top: scrollToOffset,
                        behavior: "smooth",
                    });
                    loadScripts();
                  
                resolve();
            })
            .catch((error) => {
                console.error("Error fetching updated data:", error);
                reject(error);
            });
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
            div.innerHTML = html; // Set the HTML content to the div
            formRouter(formName, item);
            enableScrolling();
            columnShift(formName, item);
        })
        .catch((error) => {
            console.error(
                "Error occurred while loading " + formName,
                +": " + error
            );
            enableScrolling();
        });
}

function columnShift(formName, jItem) {
    var item = JSON.parse(jItem);
    if (formName == "img_edit") {
        var imgCol = document.getElementById("image_" + item.rowId);
        var textCol = document.getElementById("article_" + item.rowId);
        textCol.className = "col-8  align-items-start";
        imgCol.className =
            "col-4 align-items-start justify-content-end image-column";
    }
}

function writeAndReturn(formName, newPage) {
    console.log("WRITING: " + formName);
    var form = document.getElementById(formName);
    form.addEventListener("submit", function (event) {
        event.preventDefault();
    });
    var formData = new FormData(form);
    fetch("/write_/write_form/", {
        method: "POST",
        body: formData,
    }).then((response) => {
        if (response.ok) {
            window.location.href = "/" + newPage;
        }
    });
}
function writeNoReturn(formName) {
    console.log("WRITING NO RETURN: " + formName);
    var form = document.getElementById(formName);
    if (!form) {
        console.log("NO FING FORM");
        return;
    }
    form.addEventListener("submit", function (event) {
        event.preventDefault();
    });
    var formData = new FormData(form);
    fetch("/write_/write_form/", {
        method: "POST",
        body: formData,
    });
}

function writeAndRender(formName, sequence, div) {
    console.log("WRITING: " + formName);
    var form = document.getElementById(formName);
    form.addEventListener("submit", function (event) {
        event.preventDefault();
    });

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
    var slideScripts = document.querySelectorAll(".slide_scripts");
    slideScripts.forEach((script) => {
        var innerHtml = script.innerHTML;
        var loadSlideHeightCall = innerHtml.match(/slideHeightListen\([^)]*\)/);

        if (loadSlideHeightCall !== null) {
            eval(loadSlideHeightCall[0]);
        }
    });
}
function loadNoRoutes() {
    var noRoutesScripts = document.querySelectorAll(".no-route-scripts");
    noRoutesScripts.forEach((script) => {
        var innerHtml = script.innerHTML;
        var noRouteCall = innerHtml.match(/populateRoutesNoTab\([^)]*\)/);
        if (noRouteCall !== null) {
            console.log("RAN NO ROUTE CALL");
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
    if (formName.includes("tab")) {
        editTabsSetup(formName, item);
    }
    if (formName.includes("article")) {
        articleFormRouter(formName, item);
    }
    if (formName.includes("page")) {
        pageFormRouter(formName, item);
    }
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