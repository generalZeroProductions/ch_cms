var imagesAsset;
var iconsAsset;
var fontsAsset;
var scriptAsset;
var allRoutes;

var allImages;

async function renderAll(route, pageId, scroller) {
    try {
        var navDiv = document.getElementById("main-navigation");
        var navSequence = "navigation^" + route;
        scripts = ["nav"];
        await renderToDiv(navDiv, navSequence, null, scripts);

        var footerDiv = document.getElementById("site_footer");
        scripts = ["footer"];
        await renderToDiv(footerDiv, "footer", null, scripts);

        var contentDiv = document.getElementById("page_content");
        var contentSequence = "page^" + pageId;
        scripts = ["tabs", "slides", "contact"];
        await renderToDiv(contentDiv, contentSequence, scroller, scripts);

        setHeadSpace();
    } catch (error) {
        console.error("Error rendering all components:", error);
    }
}

function renderToDiv(div, sequence, scroller, scripts) {
    return new Promise((resolve, reject) => {
        console.log(
            "RENDER TO DIV : scroller: " + scroller,
            " sequence: " + sequence
        );

        fetch("/render_/render_content/" + sequence)
            .then((response) => {
                if (!response.ok) {
                    throw new Error("response from render failed");
                }
                return response.text();
            })
            .then((html) => {
                div.innerHTML = html;
                console.log(
                    "Finished setting innerHTML for sequence=" + sequence
                );
                loadScripts(scripts);
                if (scroller) {
                    console.log("FIND SCROLLER " + scroller);
                    requestAnimationFrame(() => {
                        var row = document.getElementById(scroller);
                        if (row) {
                            console.log("found row");
                            var desiredOffset =
                                row.getBoundingClientRect().top +
                                window.scrollY -
                                headSpace; // Calculate desired offset
                            window.scrollTo({
                                top: desiredOffset,
                                behavior: "smooth",
                            });
                        } else {
                            console.log("scroll didn't find row???");
                        }
                    });
                }
                showEditors();
                resolve(); // Resolve the promise when done
            })
            .catch((error) => {
                console.error("Error fetching updated data:", error);
                reject(error); // Reject the promise in case of an error
            });
    });
}

function insertForm(formName, item, divId) {
    preventScrolling();
    hideEditors();
    var div = document.getElementById(divId);
    var jItem = JSON.parse(item);
    fetch("/insert_/insert_form/" + formName + "^" + jItem.rowId, {
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
        console.log("NO FORM AT WriteNoReturn");
        return;
    }
    form.addEventListener("submit", function (event) {
        event.preventDefault();
    });
    var formData = new FormData(form);
    fetch("/write_/write_form/", {
        method: "POST",
        body: formData,
    }).then((response) => {
        if (formName === "update_contact_form") {
            window.location = "/dashboard";
        }
        if (formName === "update_thankyou_form") {
            window.location = "/dashboard";
        }
        if (formName.includes("mark_contact_read_")) {
            const match = formName.match(/\d+$/);
            showInquiry(match);

            var btn = document.getElementById("showInquiry_btn" + match);
            btn.className = "btn btn-secondary";
        }
        if (formName.includes("delete_contact_form")) {
            paginateInquiries();
        }
    });
}

function hideEditors() {
    var allEditors = document.querySelectorAll(".hide-editor");
    allEditors.forEach((element) => {
        element.style.visibility = "hidden";
    });
    var allNavEditors = document.querySelectorAll(".hide-editor-nav");
    allNavEditors.forEach((element) => {
        element.style.display = "none";
    });
}
function showEditors() {
    var allEditors = document.querySelectorAll(".hide-editor");
    allEditors.forEach((element) => {
        element.style.visibility = "visible";
    });
    var allNavEditors = document.querySelectorAll(".hide-editor-nav");
    allNavEditors.forEach((element) => {
        element.style.display = "block";
    });
}

function writeAndRender(formName, sequence, div, scripts) {
    console.log("WRITING: " + formName + "div = " + div.id);
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
                console.log("resoponse from WRITE went well");
                renderToDiv(div, sequence, div.id, scripts);
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

function loadScripts(scripts) {
    scripts.forEach((script) => {
        if (script === "nav") {
            var editLogo = document.getElementById("logo_thumb");
            if (editLogo) {
                logoFormFillout(null);
            }
        }
        if (script === "footer") {
            var footScripts = document.querySelectorAll(".footer_scripts");
            footScripts.forEach((script) => {
                var innerHtml = script.innerHTML;
                var setUpFooterCall = innerHtml.match(
                    /changeFooterSetup\([^)]*\)/
                );
                if (setUpFooterCall !== null) {
                    eval(setUpFooterCall[0]);
                }
            });
        }
        if (script === "tabs") {
            var runScripts = document.querySelectorAll(".run-scripts");
            runScripts.forEach((script) => {
                var innerHtml = script.innerHTML;
                var loadTabCall = innerHtml.match(/changeTab\([^)]*\)/);

                if (loadTabCall !== null) {
                    eval(loadTabCall[0]);
                }
            });
            var noRoutesScripts =
                document.querySelectorAll(".no-route-scripts");
            noRoutesScripts.forEach((script) => {
                var innerHtml = script.innerHTML;
                var noRouteCall = innerHtml.match(
                    /populateRoutesNoTab\([^)]*\)/
                );
                if (noRouteCall !== null) {
                    eval(noRouteCall[0]);
                }
            });
        }
        if (script === "slides") {
            var slideScripts = document.querySelectorAll(".slide_scripts");
            slideScripts.forEach((script) => {
                var innerHtml = script.innerHTML;
                var loadSlideHeightCall = innerHtml.match(
                    /slideHeightListen\([^)]*\)/
                );

                if (loadSlideHeightCall !== null) {
                    eval(loadSlideHeightCall[0]);
                }
            });
        }
        if (script === "contact") {
            var contactScripts = document.querySelectorAll(".contactScript");
            contactScripts.forEach((script) => {
                var innerHtml = script.innerHTML;
                var contactCall = innerHtml.match(/setupContactForm\([^)]*\)/);
                if (contactCall !== null) {
                    eval(contactCall[0]);
                }
            });
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
    if (formName.includes("footer")) {
        footerFillout(formName, item);
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
