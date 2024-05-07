
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