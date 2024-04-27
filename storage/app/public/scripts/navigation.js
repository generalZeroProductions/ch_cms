var dropdownData = [];
var subNavIndex = 0;
var newNavId = -1;

function addNavItemStandard(PageId) {
    console.log("happens here");
    fetch("/add_nav_standard")
        .then((response) => response.text())
        .then((html) => {
            var modalContainer = document.getElementById("base-modal-content");
            modalContainer.innerHTML = html;
            var route_select = document.getElementById("route_select"); // Corrected id to 'route_select'
            allRoutes.forEach(function (page) {
                var option = document.createElement("option");
                option.value = page;
                option.text = page;
                route_select.appendChild(option);
            });
            var modal = document.getElementById("baseModal");
            document.getElementById("page_id").value = modal.dataset.pageId;
        })
        .catch((error) => console.error("Error loading baseModal:", error));
}

function loadEditNav(nav, div_id, location) {
    var navItem = JSON.parse(nav);
    var locItem = JSON.parse(location);
    fetch('/edit_nav_item')
        .then((response) => response.text())
        .then((html) => {
            const columnDiv = document.getElementById(div_id);
            columnDiv.innerHTML = html;
            document.getElementById("nav_title").value = navItem.title;
            document.getElementById("nav_id").value = navItem.id;
            document.getElementById("page_id").value = locItem.page.id;
            var route_select = document.getElementById("route_select"); // Corrected id to 'route_select'
            allRoutes.forEach(function (page) {
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
    var hiddenField = document.getElementById("dropDownData"); 
    hiddenField.value = JSON.stringify(dropdownData); 
    console.log("DDD " +dropdownData);
}

function removeNavItem(modContent, item, location)
{
    var navItem = JSON.parse(item);
    const locItem = JSON.parse(location);
    document.getElementById("base-modal-title").innerHTML =
    "确认删除记录 " + navItem.title;
    fetch("/delete_nav_item")
        .then((response) => response.text())
        .then((html) => {
            modContent.innerHTML = html;
            document.getElementById("nav_id").value = navItem.id;
            document.getElementById("delete_btn").innerHTML =
                "删除";
            document.getElementById("page_id").value = locItem.page.id;
        })
        .catch((error) =>
            console.error("Error loading remove nav item:", error)
        );
}

function showSelectNavType(modContent,location)
{
    fetch('/add_nav_select')
        .then((response) => response.text())
        .then((html) => {
            modContent.innerHTML = html;
            document.getElementById("base-modal-title").innerHTML =
                "创建新的导航";
        })
        .catch((error) =>
            console.error("Error loading newNavSelect:", error)
        );
}

function createSubNavItem() {
    var modContent = document.getElementById("base-modal-content");
    var list = document.getElementById("dropdown_list");
    var newItem = {
        id: newNavId,
        title: "newItem",
        route: allRoutes[0],
        index: subNavIndex,
    };
    subNavIndex += 1;
    newNavId -= 1;
    addSubItem(newItem, modContent, list);
}

function addSubItem(newItem, modContent, list) {
    dropdownData.push(newItem);
    var newDiv = document.createElement("div");
    newDiv.classList.add("row");
    newDiv.classList.add("tab_li_spacer");
    var newInput = document.createElement("input");
    newInput.setAttribute("type", "text");
    newInput.id = "text_" + newItem.id;
    newInput.value = newItem.title;
    newInput.setAttribute('autocomplete', 'off');
    newDiv.classList.add("new_item_input")
    newDiv.appendChild(newInput);
    modContent.appendChild(newDiv);
    var img = document.createElement("img");
    img.classList.add("link_icon_spacer");
    img.src = iconsAsset+'link.svg';
    newDiv.appendChild(img);
    var newSelect = document.createElement("select");
    newSelect.classList.add("form-control", "col");
    newSelect.classList.add("new_item_input")
    newSelect.id = "select_" + newItem.id;
    allRoutes.forEach(function (page) {
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
        updateSubnav(itemId, { route: selection });
    });

    newInput.addEventListener("input", function (event) {
        var text = event.target.value;
        var itemId = newItem.id;
        var text = event.target.value.trim(); 
        if (text === '') {
            newInput.style.backgroundColor = 'rgb(210, 210, 223)';
            newInput.placeholder = '不包括菜单项';
        } else {
            newInput.style.backgroundColor = ''; 
            newInput.placeholder = '';
        }
        updateSubnav(itemId, { title: text });
    });
    updateDropdownData();
}


function editDropdown(nav, subNav, location) {
    dropdownData = [];
    var navItem = JSON.parse(nav);
    var subItems = JSON.parse(subNav);
    var locItem = JSON.parse(location);
    subIndex = subItems.length;
    var modContent;
    subNavIndex = 1;
    newNavId = -1;
    fetch("/open_base_modal")
        .then((response) => response.text())
        .then((html) => {
            var modalContainer = document.createElement("div");
            modalContainer.innerHTML = html;
            document.body.appendChild(modalContainer);
            var modal = document.getElementById("baseModal");
            modal.classList.add("show");
            modal.style.display = "block";
            modContent = document.getElementById("base-modal-content");

            if (modContent) {
                const surl = "/dropdown_editor";
                fetch(surl)
                    .then((response) => response.text())
                    .then((html) => {
                        modContent.innerHTML = html;
                        document.getElementById("drop_title").value = locItem.page.id;
                            navItem.title;
                        document.getElementById("drop_id").value = navItem.id;
                        document.getElementById("page_id").value = locItem.page.id;
                        var list = document.getElementById("dropdown_list");
                       
                        subItems.forEach(function (subItem) {
                            newSubnavFromSource(
                                subItem,
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
                document.getElementById("page_id").value = modal.dataset.pageId;
                for (let i = 0; i < 5; i++) {
                    createSubNavItem();
                }
            })
            .catch((error) =>
                console.error("Error loading newNavSelect:", error)
            );
    }
}

function newSubnavFromSource(subItem, modContent, list) {
    var newItem = {
        id: subItem.id,
        title: subItem.title,
        route: subItem.route,
        index: subItem.index,
    };
    addSubItem(newItem, modContent, list);
}



function updateSubnav(itemId, newData) {
    var index = dropdownData.findIndex((item) => item.id === itemId);
    if (index !== -1) {
        dropdownData[index] = { ...dropdownData[index], ...newData };
    }
    updateDropdownData();
}
