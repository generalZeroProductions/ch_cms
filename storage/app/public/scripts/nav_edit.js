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



function modalContentNav(action,item)
{
    document.getElementById("main_modal").dataset.pageId = locItem.page.id;
    if (action === "editNavStandard") {
        loadEditNav(item);
    }
    else if (action === "selectNavType") {
        newNavSelectForm();
    }
    else if (action === "editDropdown") {
        editDropdown(item);
    }
}


function newNavSelectForm()
{
    fetch('/add_nav_select')
        .then((response) => response.text())
        .then((html) => {
            modBody.innerHTML = html;
            modTitleLabel.innerHTML =
                "创建新的导航";
        })
        .catch((error) =>
            console.error("Error: couldn't load form form: -> new_nav_selector. Details:", error)
        );
}

function loadEditNav(item) {
    var navItem = JSON.parse(item);
    var modLabel = document.getElementById("main_modal_label");
    modLabel.innerHTML = " 更改导航项";
    fetch('/edit_nav_item')
        .then((response) => response.text())
        .then((html) => {
            modBody.innerHTML = html;
            document.getElementById("nav_title").value = navItem.title;
            document.getElementById("nav_id").value = navItem.id;
            document.getElementById("page_id").value = locItem.page.id;
            document.getElementById("scroll_to").value = scrollBackTo;
            var route_select = document.getElementById("route_select"); 
            allRoutes.forEach(function (page) {
                var option = document.createElement("option");
                option.value = page;
                option.text = page;
                if (page === navItem.route) {
                    option.selected = true; 
                }
                route_select.appendChild(option);
            });
        })
        .catch((error) => console.error("Error: couldn't load form form: -> eidt_nav_standard. Details:", error));
}

function addNavItemStandard() {
    fetch("/add_nav_standard")
        .then((response) => response.text())
        .then((html) => {
            modBody.innerHTML = html;
            var route_select = document.getElementById("route_select"); // Corrected id to 'route_select'
            allRoutes.forEach(function (routeName) {
                var option = document.createElement("option");
                option.value = routeName;
                option.text = routeName;
                route_select.appendChild(option);
            });
            var modal = document.getElementById("main_modal");
            document.getElementById("page_id").value = modal.dataset.pageId;
            document.getElementById("scroll_to").value = scrollBackTo;
        })
        .catch((error) => console.error("Error: couldn't load form form: -> add_nav_standard. Details:", error));
}



function removeNavWarning(item)
{
    var navItem = JSON.parse(item);
    document.getElementById("main_modal_label").innerHTML =
    "确认删除记录 " + navItem.title;
    fetch("/delete_nav_item")
        .then((response) => response.text())
        .then((html) => {
            modBody.innerHTML = html;
            document.getElementById("nav_id").value = navItem.id;
            document.getElementById("delete_btn").innerHTML =
                "删除";
            document.getElementById("page_id").value = locItem.page.id;
            document.getElementById("scroll_to").value = scrollBackTo;
        })
        .catch((error) =>
            console.error("Error loading remove nav item:", error)
        );
}