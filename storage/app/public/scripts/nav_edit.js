

function filloutNavForms(formName, jItem) {
    var form = document.getElementById(formName);
    if (form) {
        form.addEventListener("submit", function (event) {
            event.preventDefault();
        });
    }
    if (formName === "edit_nav") {
        var item = JSON.parse(jItem);
        addFieldAndValue("item_id", item.nav.id);
        addFieldAndValue(formName + "_title", item.nav.title);
        addFieldAndValue("key", item.key);
        var route_select = document.getElementById("route_select");
        var option = document.createElement("option");
        option.value = "选择页面路由";
        option.text = "选择页面路由";
        route_select.appendChild(option);
        allRoutes.forEach(function (page) {
            var option = document.createElement("option");
            option.value = page;
            option.text = page;
            if (page === item.nav.route) {
                option.selected = true;
            }
            route_select.appendChild(option);
        });
        var option = document.createElement("option");
        option.value = "联系我们";
        option.text = "联系我们";
        if (item.route === "联系我们") {
            option.selected = true;
        }
        route_select.appendChild(option);
        var div = document.getElementById("main-navigation");
        var sequence = "navigation^" + item.key;
        setupFormSubmit(formName, sequence, div);
    }
    if (formName == "nav_delete") {
        console.log(jItem);
        var item = JSON.parse(jItem);
        addFieldAndValue("item_id", item.id);

        var deleteBtn = document.getElementById("delete_nav_btn");
        var div = document.getElementById("main-navigation");
        var sequence = "navigation^" + item.id;
        deleteBtn.onclick = function () {
            writeAndRender("nav_delete", sequence, div);
        };
        var cancelBtn = document.getElementById("cancel_delete_btn");
        cancelBtn.onclick = function () {
            renderNavigation(item.index);
        };
    }

    if (formName === "add_nav") {
        console.log(jItem);
        addFieldAndValue("standard_key", jItem);
        addFieldAndValue("dropdown_key", jItem);
        var addDiv = document.getElementById("add_at" + jItem);
        addDiv.classList.remove("adder-narrow");
        addDiv.classList.add("adder-wide");
        var div = document.getElementById("main-navigation");
        var sequence = "navigation^" + jItem;
        var standardBtn = document.getElementById("add_standard_btn");
        standardBtn.onclick = function () {
            writeAndRender("add_standard", sequence, div);
        };
        var dropdownBtn = document.getElementById("add_dropdown_btn");
        dropdownBtn.onclick = function () {
            writeAndRender("add_dropdown", sequence, div);
        };
        var cancelAdd = document.getElementById("cancel_add_nav");
        cancelAdd.onclick = function () {
            renderNavigation(jItem);
        };
    }

    if (formName === "dropdown_editor_nav") {
        var item = JSON.parse(jItem);
        var div = document.getElementById("main-navigation");
        var sequence = "navigation^" + item.key;
        setupFormSubmit(formName, sequence, div);
        dropdownData = [];
        deletedSubs = [];

        var navItem = item.nav;
        var subItems = item.sub;
        subIndex = subItems.length;
        subNavIndex = 1;
        newNavId = -1;

        addFieldAndValue(formName + "_title", navItem.title);
        addFieldAndValue("item_id", navItem.id);
        addFieldAndValue("key", item.key);
        var list = document.getElementById("dropdown_list");
        subItems.forEach(function (subItem) {
            newSubnavFromSource(subItem, list);
        });
    }
}
