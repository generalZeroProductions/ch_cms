var dropdownData = [];
var subNavIndex = 0;
var newNavId = -1;

// function addDropdownNav() {
//     dropdownData = [];
//     subNavIndex = 1;
//     newNavId = -1;
//     const modal = document.getElementById("main_modal");
//     fetch("/dropdown_adder")
//         .then((response) => response.text())
//         .then((html) => {
//             modBody.innerHTML = html;
//             document.getElementById("drop_title").value = "new dropdown";
//             document.getElementById("page_id").value = modal.dataset.pageId;
//             document.getElementById("scroll_to").value = scrollBackTo;
//             for (let i = 0; i < 3; i++) {
//                 createSubNavItem();
//             }
//         })
//         .catch((error) => console.error("Error loading newNavSelect:", error));
// }

// function editDropdown(item) {
//     dropdownData = [];
//     var parseItem = JSON.parse(item);
//     var navItem = parseItem['nav'];
//     var subItems = parseItem['sub'];
//     subIndex = subItems.length;
//     modTitleLabel.innerHTML = "更改下拉菜单";
//     subNavIndex = 1;
//     newNavId = -1;
//     fetch("/dropdown_editor")
//         .then((response) => response.text())
//         .then((html) => {
//             modBody.innerHTML = html;
//             document.getElementById("drop_title").value = navItem.title;
//             document.getElementById("drop_id").value = navItem.id;
//             document.getElementById("page_id").value = locItem.page.id;
//             document.getElementById("scroll_to").value = scrollBackTo;
//             var list = document.getElementById("dropdown_list");
//             subItems.forEach(function (subItem) {
//                 newSubnavFromSource(subItem, list);
//             });
//         })
//         .catch((error) => console.error("Error loading form:-> edit_dropdown_form. Details: ", error));
// }

function createSubNavItem() {
    var list = document.getElementById("dropdown_list");
    var newItem = {
        id: newNavId,
        title: "newItem",
        route: allRoutes[0],
        index: dropdownData.length,
    };
    newNavId -= 1;
    addSubItem(newItem, list);
}

function addSubItem(newItem, list) {

    dropdownData.push(newItem);
    var newDiv = document.createElement("div");
    newDiv.classList.add("d-flex");
    newDiv.classList.add("tab_li_spacer");
    var newInput = document.createElement("input");
    newInput.setAttribute("type", "text");
    newInput.id = "text_" + newItem.id;
    newInput.value = newItem.title;
    newInput.classList.add("form-control" , "local-ctl");
    newInput.setAttribute("autocomplete", "off");
    newDiv.appendChild(newInput);
   
    list.appendChild(newDiv);
    var newDiv2 = document.createElement("div");
    newDiv2.classList.add("d-flex");
    var img = document.createElement("img");
    img.classList.add("link_icon_spacer");
    img.src = iconsAsset + "link.svg";
    newDiv2.appendChild(img);
    var newSelect = document.createElement("select");
    newSelect.classList.add("form-control", "local-ctl");
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
    newDiv2.appendChild(newSelect);
    list.appendChild(newDiv2);
    
    newSelect.addEventListener("change", function (event) {
        var selection = event.target.value;
        var itemId = newItem.id;
        updateSubnav(itemId, { route: selection });
    });
    
    newInput.addEventListener("input", function (event) {
        var text = event.target.value;
        var itemId = newItem.id;
        var text = event.target.value.trim();
        if (text === "") {
            newInput.style.backgroundColor = "rgb(210, 210, 223)";
            newInput.placeholder = "不包括菜单项";
        } else {
            newInput.style.backgroundColor = "";
            newInput.placeholder = "";
        }
        updateSubnav(itemId, { title: text });
    });
    
    updateDropdownData();
    
}

function newSubnavFromSource(subItem, list) {
    var newItem = {
        id: subItem.id,
        title: subItem.title,
        route: subItem.route,
        index: subItem.index,
    };
    addSubItem(newItem, list);
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
}
