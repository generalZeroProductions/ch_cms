function loadPage(routeName) {
    // Make an AJAX request to fetch the page content
    fetch("/load-page/" + routeName)
        .then((response) => response.text()) // Parse response as text
        .then((html) => {
            // Replace the content of the 'content' section with the fetched HTML
            document.getElementById("content").innerHTML = html;
            const scripts = document
                .getElementById("content")
                .getElementsByTagName("script");
            for (let i = 0; i < scripts.length; i++) {
                eval(scripts[i].innerHTML); // Execute script using eval
            }
        })
        .catch((error) => console.error("Error loading page:", error));
}

function addNavItemStandard() {
    var modal = document.getElementById("baseModal");
    var allTitles = JSON.parse(modal.dataset.allTitles);
    console.log(allTitles);
    const url = "/add_nav_standard";
    var modContent;
    fetch(url)
        .then((response) => response.text())
        .then((html) => {
            var modalContainer = document.getElementById("base-modal-content");
            modalContainer.innerHTML = html;
            var route_select = document.getElementById("route_select"); // Corrected id to 'route_select'
            allTitles.forEach(function (page) {
                var option = document.createElement("option");
                option.value = page;
                option.text = page;
                route_select.appendChild(option);
            });
        })
        .catch((error) => console.error("Error loading baseModal:", error));
}

function openBaseModal(action, allTitles, item, pageId) {
    const url = "/open_base_modal";
    var modContent;
    console.log("action = " + action);
    fetch(url)
        .then((response) => response.text())
        .then((html) => {
            var modalContainer = document.createElement("div");
            modalContainer.innerHTML = html;
            document.body.appendChild(modalContainer);
            var modal = document.getElementById("baseModal");
            modal.classList.add("show");
            modal.style.display = "block";
            modal.dataset.allTitles = allTitles;
            modContent = document.getElementById("base-modal-content");

            // Check if modContent is assigned and action is "selectType" before fetching additional content
            if (action === "selectType" && modContent) {
                const surl = "/add_nav_select";
                fetch(surl)
                    .then((response) => response.text())
                    .then((html) => {
                        modContent.innerHTML = html;
                    })
                    .catch((error) =>
                        console.error("Error loading newNavSelect:", error)
                    );
            }
            if (action === "removeItem" && modContent) {
                const surl = "/delete_nav_item";
                var navItem = JSON.parse(item);
                fetch(surl)
                    .then((response) => response.text())
                    .then((html) => {
                        modContent.innerHTML = html;
                        document.getElementById("nav_id").value = navItem.id;
                        document.getElementById("delete_btn").innerHTML =
                            "Confirm Delete " + navItem.title;
                    })
                    .catch((error) =>
                        console.error("Error loading newNavSelect:", error)
                    );
            }
        })
        .catch((error) => console.error("Error loading baseModal:", error));
}

const csrfToken = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");
var linkImagePath;
var dropdownData = [];

function updateDropdownData() {
    var hiddenField = document.getElementById("dropDownData"); // Assuming 'data' is the ID of the hidden field
    hiddenField.value = JSON.stringify(dropdownData); // Convert the object to a JSON string and set it as the value of the hidden field
    console.log("update made " + dropdownData);
}

var subNavIndex = 0;
var newNavId = -1;

function createSubNavItem() {
    var modContent = document.getElementById("base-modal-content");
    var modal = document.getElementById("baseModal");
    var list = document.getElementById("dropdown_list");
    var pageTitles = JSON.parse(modal.dataset.allTitles);
    var newItem = {
        id: newNavId,
        title: "newItem",
        route: pageTitles[0],
        index: subNavIndex,
    };
    subNavIndex += 1;
    newNavId -= 1;
    addSubItem(newItem, pageTitles, modContent, list);
}

function editDropdown(nav, subNav, allTitles) {
    dropdownData = [];
    var navItem = JSON.parse(nav);
    var subItems = JSON.parse(subNav);
    subIndex = subItems.length;
    const url = "/open_base_modal";
    var modContent;
    var pageTitles = JSON.parse(allTitles);
    subNavIndex = 1;
    newNavId = -1;
    fetch(url)
        .then((response) => response.text())
        .then((html) => {
            var modalContainer = document.createElement("div");
            modalContainer.innerHTML = html;
            document.body.appendChild(modalContainer);
            var modal = document.getElementById("baseModal");
            modal.classList.add("show");
            modal.style.display = "block";
            modal.dataset.allTitles = allTitles;
            modContent = document.getElementById("base-modal-content");

            if (modContent) {
                const surl = "/dropdown_editor";
                fetch(surl)
                    .then((response) => response.text())
                    .then((html) => {
                        modContent.innerHTML = html;
                        document.getElementById("drop_title").value =
                            navItem.title;
                        document.getElementById("drop_id").value = navItem.id;
                        var list = document.getElementById("dropdown_list");
                        subItems.forEach(function (subItem) {
                            newItemFromSource(
                                subItem,
                                pageTitles,
                                modContent,
                                list
                            );
                        });
                    })
                    .catch((error) =>
                        console.error("Error loading newNavSelect:", error)
                    );
            }
        })
        .catch((error) => {
            // Handle errors
            console.error("Error:", error);
        });
}

function addDropdownNav() {
    dropdownData = [];
    var modContent;
    subNavIndex = 1;
    newNavId = -1;

    modContent = document.getElementById("base-modal-content");

    if (modContent) {
        const surl = "/dropdown_adder";
        fetch(surl)
            .then((response) => response.text())
            .then((html) => {
                modContent.innerHTML = html;
                document.getElementById("drop_title").value = "new dropdown";
                var list = document.getElementById("dropdown_list");
                for (let i = 0; i < 5; i++) {
                    createSubNavItem();
                }
            })
            .catch((error) =>
                console.error("Error loading newNavSelect:", error)
            );
    }
}

function newItemFromSource(subItem, pageTitles, modContent, list) {
    var newItem = {
        id: subItem.id,
        title: subItem.title,
        route: subItem.route,
        index: subItem.index,
    };
    addSubItem(newItem, pageTitles, modContent, list);
}

function addSubItem(newItem, pageTitles, modContent, list) {
    dropdownData.push(newItem);
    console.log(newItem + " :: at add Item");
    var newDiv = document.createElement("div");
    newDiv.classList.add("row");
    var newInput = document.createElement("input");
    newInput.setAttribute("type", "text");
    newInput.id = "text_" + newItem.id;
    newInput.value = newItem.title;
    newDiv.appendChild(newInput);
    modContent.appendChild(newDiv);
    var img = document.createElement("img");
    img.classList.add("link_icon_spacer");
    img.src = linkImagePath;
    newDiv.appendChild(img);
    var newSelect = document.createElement("select");
    newSelect.classList.add("form-control", "col");
    newSelect.id = "select_" + newItem.id;
    pageTitles.forEach(function (page) {
        var option = document.createElement("option");
        option.value = page;
        option.text = page;
        if (page === newItem.route) {
            option.selected = true; // Set 'selected' attribute for the default value
        }
        newSelect.appendChild(option);
    });
    newDiv.appendChild(newSelect);
    list.appendChild(newDiv);
    newSelect.addEventListener("change", function (event) {
        var selection = event.target.value;
        var itemId = newItem.id;
        updateItem(itemId, { route: selection });
    });

    // Add input event listener to text field
    newInput.addEventListener("input", function (event) {
        var text = event.target.value;
        var itemId = newItem.id;
        updateItem(itemId, { title: text });
    });
    updateDropdownData();
}

function updateItem(itemId, newData) {
    var index = dropdownData.findIndex((item) => item.id === itemId);
    if (index !== -1) {
        dropdownData[index] = { ...dropdownData[index], ...newData };
    }
    updateDropdownData();
}

function closeModal(modalId) {
    var modal = document.getElementById(modalId);
    modal.classList.remove("show");
    // modal.style.display = 'none';

    // Ensure that modal backdrop is also hidden
    var modalBackdrop = document.querySelector(".modal-backdrop");
    // modalBackdrop.style.display = 'none';

    // Remove the modal element from the DOM
    modal.remove();
}

function loadEditNav(nav_title, nav_id, route, div_id, page_list, page_id) {
    const url = "/edit_nav_item";
    var pageTitles = JSON.parse(page_list);
    fetch(url)
        .then((response) => response.text())
        .then((html) => {
            const columnDiv = document.getElementById(div_id);
            columnDiv.innerHTML = html;
            document.getElementById("nav_title").value = nav_title;
            document.getElementById("nav_id").value = nav_id;
            // document.getElementById('page_id').value = page_id;
            var route_select = document.getElementById("route_select"); // Corrected id to 'route_select'
            pageTitles.forEach(function (page) {
                var option = document.createElement("option");
                option.value = page;
                option.text = page;
                route_select.appendChild(option);
            });
        })
        .catch((error) => console.error("Error loading edit form:", error));
}

function loadEditNav2(nav, div_id, page_list) {
    const url = "/edit_nav_item";
    var pageTitles = JSON.parse(page_list);
    var navItem = JSON.parse(nav);
    fetch(url)
        .then((response) => response.text())
        .then((html) => {
            const columnDiv = document.getElementById(div_id);
            columnDiv.innerHTML = html;
            document.getElementById("nav_title").value = navItem.title;
            document.getElementById("nav_id").value = navItem.id;
            var route_select = document.getElementById("route_select"); // Corrected id to 'route_select'
            pageTitles.forEach(function (page) {
                var option = document.createElement("option");
                option.value = page;
                option.text = page;
                if (page === navItem.route) {
                    option.selected = true; // Set 'selected' attribute for the default value
                }
                route_select.appendChild(option);
            });
        })
        .catch((error) => console.error("Error loading edit form:", error));
}

function printPhpVar(phpvar) {
    console.log("var = " + phpvar);
}
