var dropdownData = [];
var deletedSubs = [];
var subNavIndex = 0;

function newSubnavFromSource(subItem, list) {
    var newItem = {
        record: true,
        id: subItem.id,
        title: subItem.title,
        route: subItem.route,
        index: subItem.index,
        trash: subItem.title + subItem.index,
    };
    addSubItem(newItem, list);
}
function createSubNavItem() {
    var list = document.getElementById("dropdown_list");
    var newItem = {
        record: false,
        title: "新子菜单" + dropdownData.length,
        route: "/",
        index: dropdownData.length - 1,
        trash: "newItem" + dropdownData.length,
    };

    addSubItem(newItem, list);
}
function deleteSubNav(index) {
    var deleted_sub = dropdownData[index];
    deletedSubs.push(deleted_sub);
    updateData = JSON.stringify(deletedSubs);
    var deletedSubssField = document.getElementById("deleted_subs");
    deletedSubssField.value = updateData;

    if (index !== -1) {
        dropdownData.splice(index, 1);
        dropdownData.forEach((item) => {
            if (item.index > index) {
                item.index--;
            }
        });
    }
    var divToRemove = document.getElementById(deleted_sub.trash);
    divToRemove.remove();
    updateDropdownData();
}

function addSubItem(newItem, list) {
    dropdownData.push(newItem);
    var subItemDiv = document.createElement("div");
    subItemDiv.id = newItem.trash;
    var newDiv = document.createElement("div");
    newDiv.classList.add("d-flex");
    newDiv.classList.add("tab_li_spacer");
    var deleteLink = document.createElement("a");

    deleteLink.onclick = function () {
        deleteSubNav(newItem.index);
    };

    deleteLink.classList.add("trashcan");
    var img1 = document.createElement("img");
    img1.classList.add("link_icon_spacer");
    img1.src = iconsAsset + "trash.svg";
    deleteLink.appendChild(img1);
    newDiv.appendChild(deleteLink);
    deleteLink.style.cursor = "pointer";
    var newInput = document.createElement("input");
    newInput.setAttribute("type", "text");
    newInput.id = "text_" + newItem.id;
    newInput.value = newItem.title;
    newInput.classList.add("form-control", "local-ctl", "subItemInput");
    newInput.setAttribute("autocomplete", "off");
    newDiv.appendChild(newInput);
    subItemDiv.appendChild(newDiv);
    var newDiv2 = document.createElement("div");
    newDiv2.classList.add("d-flex");
    var img = document.createElement("img");
    img.classList.add("link_icon_spacer");
    img.src = iconsAsset + "link.svg";
    newDiv2.appendChild(img);
    var newSelect = document.createElement("select");
    newSelect.classList.add("form-control", "local-ctl");
    newSelect.id = "select_" + newItem.id;
    var option = document.createElement("option");
    option.value = "选择页面路由";
    option.text = "选择页面路由";

    newSelect.appendChild(option);
    allRoutes.forEach(function (page) {
        var option = document.createElement("option");
        option.value = page;
        option.text = page;
        if (page === newItem.route) {
            option.selected = true;
        }
        newSelect.appendChild(option);
    });
    var option = document.createElement("option");
    option.value = "联系我们";
    option.text = "联系我们";
    if (newItem.route=== "联系我们") {
        option.selected = true;
    }
    newSelect.appendChild(option);

    newDiv2.appendChild(newSelect);
    subItemDiv.appendChild(newDiv2);
    list.appendChild(subItemDiv);

    newSelect.addEventListener("change", function (event) {
        var selection = event.target.value;
        var itemId = newItem.id;
        updateSubnav(itemId, { route: selection });
    });

    newInput.addEventListener("input", function (event) {
        validateForm(newInput, event);
        var itemId = newItem.id;
        var text = event.target.value;
        updateSubnav(itemId, { title: text });
    });

    updateDropdownData();
}

function updateSubnav(itemId, newData) {
    var index = dropdownData.findIndex((item) => item.id === itemId);
    if (index !== -1) {
        dropdownData[index] = { ...dropdownData[index], ...newData };
    }
    updateDropdownData();
}

function updateDropdownData() {
    var hiddenField = document.getElementById("dropDownData");
    hiddenField.value = JSON.stringify(dropdownData);
    var trash = document.querySelectorAll(".trashcan");
    if (dropdownData.length === 1) {
        trash.forEach((element) => {
            element.style.visibility = "hidden";
        });
    } else {
        trash.forEach((element) => {
            element.style.visibility = "visible";
        });
    }
}
