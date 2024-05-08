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
    const div = document.getElementById("page_content");
    const sequence = "/refresh_/page^" + pageId;
    refreshDiv(div, sequence)
    .then(() => {
        loadScripts();
    })
    .catch((error) => {
        console.error('Error refreshing page:', error);
    });
}
function decodeRoutes(encodedString) {
    var decodedString = encodedString.replace(/&quot;/g, '"');
    var array = JSON.parse(decodedString);
    return array;
}


function insertForm(item, formName, divId, key) {
    preventScrolling();
    const jItem = JSON.parse(item);

    const div = document.getElementById(divId);
    fetch("/read_/" + formName, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
        },
    })
        .then((response) => response.text()) // Parse response as text
        .then((html) => {
            div.innerHTML = html; // Set the HTML content to the div
            fillForm(jItem, formName, div, key);
            enableScrolling();
        })
        .catch((error) => {
            console.error(
                "Error occurred while loading " + formName,
                +": " + error
            );
            enableScrolling();
        });
}



function fillForm(item, formName, div, key) {
    var intercept = false;
    if (formName.includes("nav")) {
        intercept = filloutNavForms(item, formName, key);
    }
    if (intercept) {
        setCusomSubmitNav(formName, item, div, key);
    }
}

function addFieldAndValue(fieldName, fieldValue) {
    var field = document.getElementById(fieldName);
    field.value = fieldValue;
}

function setCusomSubmitNav(formName, item, div, key) {
    const form = document.getElementById(formName);
    if (formName === "nav_dropdown") {
        item = item.nav;
    }
    form.addEventListener("submit", function (event) {
        submitUpdateRequest(form, item, formName, div, event, key);
    });
}

function refreshDiv(div, sequence) {
    return new Promise((resolve, reject) => {
        fetch(sequence)
            .then((response) => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text(); // Parse response as text
            })
            .then((html) => {
                // Set the HTML content of the div
                div.innerHTML = html;
                // Resolve the promise to indicate success
                resolve();
            })
            .catch((error) => {
                // Handle errors by logging or throwing
                console.error('Error fetching updated data:', error);
                // Reject the promise to propagate the error
                reject(error);
            });
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
        console.log("OOKK");
        var innerHtml = script.innerHTML;
        var noRouteCall = innerHtml.match(/populateRoutesNoTab\([^)]*\)/);
        if (noRouteCall !== null) {
            eval(noRouteCall[0]);
        }
    });
}

function submitUpdateRequest(form, item, formName, div, event, key) {
    preventScrolling();
    const formData = new FormData(form);
    event.preventDefault();
    fetch("/write_nav/", {
        method: "POST",
        body: formData,
    })
        .then((response) => {
            if (response.ok) {
                refreshDiv(
                    div,
                    "/refresh_/" + formName + "^" + item.id + "^" + key
                );
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


function authOn() {
    fetch("/admin/on", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
    })
        .then((response) => {
            if (response.ok) {
                console.log("Authentication turned on successfully");
            } else {
                console.error("Failed to turn on authentication");
            }
        })
        .catch((error) => {
            console.error(
                "Error occurred while turning on authentication:",
                error
            );
        });
}

function authOff() {
    fetch("/admin/off", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
    })
        .then((response) => {
            if (response.ok) {
                console.log("Authentication turned off successfully");
            } else {
                console.error("Failed to turn off authentication");
            }
        })
        .catch((error) => {
            console.error(
                "Error occurred while turning off authentication:",
                error
            );
        });
}
