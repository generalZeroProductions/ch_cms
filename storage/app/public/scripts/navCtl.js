
var dropdownData = [];
var subNavIndex = 0;
var newNavId = -1;

function addNavItemStandard() {
    var modal = document.getElementById("baseModal");
    var allTitles = JSON.parse(modal.dataset.allTitles);
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

function loadEditNav(nav, div_id, page_list, pageName) {
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
            document.getElementById("page_name").value = pageName;
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



function updateDropdownData() {
    var hiddenField = document.getElementById("dropDownData"); // Assuming 'data' is the ID of the hidden field
    hiddenField.value = JSON.stringify(dropdownData); // Convert the object to a JSON string and set it as the value of the hidden field
    console.log("update made " + dropdownData);
}



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
    const modal = document.getElementById("baseModal");
    if (modContent) {
        const surl = "/dropdown_adder";
        fetch(surl)
            .then((response) => response.text())
            .then((html) => {
                modContent.innerHTML = html;
                document.getElementById("drop_title").value = "new dropdown";
                document.getElementById("page_name").value = modal.dataset.pageName;
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
    newDiv.classList.add("tab_li_spacer");
    var newInput = document.createElement("input");
    newInput.setAttribute("type", "text");
    newInput.id = "text_" + newItem.id;
    newInput.value = newItem.title;
    newDiv.classList.add("new_item_input")
    newDiv.appendChild(newInput);
    modContent.appendChild(newDiv);
    var img = document.createElement("img");
    img.classList.add("link_icon_spacer");
    img.src = linkImagePath;
    newDiv.appendChild(img);
    var newSelect = document.createElement("select");
    newSelect.classList.add("form-control", "col");
    newSelect.classList.add("new_item_input")
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
