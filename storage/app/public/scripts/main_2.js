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

function decodeRoutes(encodedString) {
    var decodedString = encodedString.replace(/&quot;/g, '"');
    var array = JSON.parse(decodedString);
    return array;
}

// const csrfToken = document
//     .querySelector('meta[name="csrf-token"]')
//     .getAttribute("content");

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
        });
}

function filloutNavForms(item, formName, key) {
    var intercept = false;

    if (formName === "nav_standard") {
        addFieldAndValue("item_id", item.id);
        addFieldAndValue("title", item.title);
        var route_select = document.getElementById("route_select");
        allRoutes.forEach(function (page) {
            var option = document.createElement("option");
            option.value = page;
            option.text = page;
            if (page === item.route) {
                option.selected = true;
            }
            route_select.appendChild(option);
        });
        intercept = true;
    }
    if (formName == "nav_delete") {
        addFieldAndValue("item_id", item.id);
        addFieldAndValue("scroll_to", window.scrollY);
        addFieldAndValue("location", location);
        addFieldAndValue("key", key);
        console.log(location);
    }
    if (formName === "nav_add") {
        addFieldAndValue("standard_scroll", window.scrollY);
        addFieldAndValue("standard_loc", location);
        addFieldAndValue("standard_item_id", item.id);
        addFieldAndValue("standard_key", key);

        addFieldAndValue("drop_scroll", window.scrollY);
        addFieldAndValue("drop_loc", location);
        addFieldAndValue("dropdown_item_id", item.id);
        addFieldAndValue("dropdown_key", key);

        addFieldAndValue("cancel_scroll", window.scrollY);
        addFieldAndValue("cancel_loc", location);
        addFieldAndValue("cancel_item_id", item.id);
        addFieldAndValue("cancel_key", key);
    }
    if (formName === "nav_dropdown") {
        dropdownData = [];
        var navItem = item.nav;
        var subItems = item.sub;
        subIndex = subItems.length;
        subNavIndex = 1;
        newNavId = -1;
        addFieldAndValue("title", navItem.title);
        addFieldAndValue("item_id", navItem.id);
        addFieldAndValue("key", key);
        var list = document.getElementById("dropdown_list");
        subItems.forEach(function (subItem) {
            newSubnavFromSource(subItem, list);
        });
        intercept = true;
    }
    return intercept;
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

function refreshDiv(div, sequence) {
    fetch(sequence)
        .then((response) => response.text()) // Parse response as text
        .then((html) => {
            div.innerHTML = html;  
        })
        .catch((error) => {
            console.error("Error fetching updated data:", error);
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
