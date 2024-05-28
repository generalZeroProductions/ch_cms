function paginatePages(index) {
    const pagesDiv = document.getElementById("pagesDiv");
    fetchRecords("/display_all_pages/" + index, pagesDiv);
}

function paginateInquiries(index, scroller) {
    const inquiriesDiv = document.getElementById("inquiresDiv");
    fetchRecords("/display_all_inquiries/" + index, inquiriesDiv, scroller);
}

function paginateUsers(index, scroller) {
    const usersDiv = document.getElementById("usersDiv");
    fetchRecords("/display_all_users/" + index, usersDiv, scroller);
}

async function paginateAll(
    pageIndex,
    inqIndex,
    userIndex,
    showUsers,
    scroller
) {
    
    try {
        await paginatePages(pageIndex, false);

        await paginateInquiries(inqIndex, scroller);
        if (showUsers) {
            await paginateUsers(userIndex, scroller);
        }
        
       
    } catch (error) {
        console.error("Error rendering all components:", error);
    }
}

function fetchRecords(url, div, scroller) {
    fetch(url)
        .then((response) => response.json())
        .then((data) => {
            div.innerHTML = data.html;
            if(scroller)
                {
                    window.scrollTo(0,scroller);
                }
        })
        .catch((error) => console.error("Error loading inquiries:", error));
}

function addUser(jItem) {
    var item = JSON.parse(jItem);
    scrollBack = window.scrollY;

    document.getElementById("main_modal_label").innerHTML = "添加用户";
    fetch("/add_user")
        .then((response) => response.text())
        .then((html) => {
            if (modBody) {
                modBody.innerHTML = html;
                var scrollDash = document.getElementById("scrollDash");
                scrollDash.value = scrollBack;
                var nameField = document.getElementById("add_user_name");

                var passField = document.getElementById("add_pass_word");
                var addBtn = document.getElementById("add_user_btn");
                nameField.addEventListener("input", function () {
                    checkEmptyUser(nameField, item);
                });
                passField.addEventListener("input", function () {
                    checkEmptyPassword(passField);
                });
                addBtn.addEventListener("click", function () {
                    validateNewUserEntry("add_user_form", nameField, passField);
                });
            } else {
                console.log("NO MOD BODY");
            }
        })
        .catch((error) =>
            console.error("Error loading add user form:", error)
        );
}

function deleteUser(item) {
    scrollBack = window.scrollY;
    fetch("/delete_user")
        .then((response) => response.text())
        .then((html) => {
            if (modBody) {
                modBody.innerHTML = html;
                var scrollDash = document.getElementById("scrollDash");
                scrollDash.value = scrollBack;
                var idField = document.getElementById("user_id");
                idField.value = item;
            } else {
                console.log("Couldn't get Modal Body");
            }
        })
        .catch((error) =>
            console.error("Error loading  delete User item:", error)
        );
}

function editUser(jItem) {
    var item = JSON.parse(jItem);
    scrollBack = window.scrollY;
    document.getElementById("main_modal_label").innerHTML = "添加用户";
    fetch("/edit_user")
        .then((response) => response.text())
        .then((html) => {
            if (modBody) {
                modBody.innerHTML = html;
                var scrollDash = document.getElementById("scrollDash");
                scrollDash.value = window.scrollY;
                var nameField = document.getElementById("edit_user_name");
                nameField.value = item.user.name;
                var passField = document.getElementById("edit_pass_word");
                var addBtn = document.getElementById("add_user_btn");
                var userIdfield = document.getElementById("userId");
                userIdfield.value = item.user.id;
                nameField.addEventListener("input", function () {
                    checkEmptyUser(nameField, item.users);
                });
                passField.addEventListener("input", function () {
                    checkEmptyPassword(passField);
                });
                addBtn.addEventListener("click", function () {
                    validateNewUserEntry(
                        "edit_user_form",
                        nameField,
                        passField
                    );
                });

                scrollDash.value = scrollBack;
            } else {
                console.log("NO MOD BODY");
            }
        })
        .catch((error) =>
            console.error("Error loading  delete Contact item:", error)
        );
}

var originalUserName = null;

function uniqueUserName(field, users) {
    var notUnique = document.getElementById("warn_not_unique");
    var unique = true;

    for (var i = 0; i < users.length; i++) {
        if (field.value === users[i].name) {
            notUnique.style.display = "block";
            unique = false;
            break;
        }
    }
    if (unique) {
        notUnique.style.display = "none";
    }
    return unique;
}

function checkEmptyUser(field, users) {
    var noUserName = document.getElementById("warn_no_username");

    if (field.value.trim() === "") {
        noUserName.style.display = "block";
    } else {
        noUserName.style.display = "none";
    }
    var uniquName = document.getElementById("warn_not_unique");
    if (!uniqueUserName(field, users)) {
        uniquName.style.display = "block";
    } else {
        uniquName.style.display = "none";
    }
}
function checkEmptyPassword(field) {
    var nowPassword = document.getElementById("warn_no_password");
    if (field.value.trim() === "") {
        nowPassword.style.display = "block";
    } else {
        nowPassword.style.display = "none";
    }
}
function validateNewUserEntry(formName, name, pass) {
    var form = document.getElementById(formName);
    var notUnique = document.getElementById("warn_not_unique");
    var noUserName = document.getElementById("warn_no_username");
    var nowPassword = document.getElementById("warn_no_password");
    var valid = true;
    if (name.value.trim() === "") {
        valid = false;
        noUserName.style.display = "block";
    }

    if (pass.value.trim() === "") {
        valid = false;
        nowPassword.style.display = "block";
    }

    if (valid) {
        if (notUnique.style.display === "none") {
            form.submit();
        }
    }
}
function viewSite(route) {
    window.location.href = "/session/view?" + route;
}
function dashboardReturn() {
    window.location.href = "/session/endbuild";
}
function setEditMode(toggle) {
    scrollDiv = findClosestDiv();
    var pathname = window.location.pathname;
    var parts = pathname.split("/");
    var route = parts[parts.length - 1];
    window.location.href =
        "/session/edit?" + toggle + "?" + route + "?" + scrollDiv;
}

function findClosestDiv() {
    var rowMarks = document.querySelectorAll(".rowInsert");
    let closestDiv = null;
    let minVerticalDistance = Infinity;
    const verticalCenter = window.innerHeight / 2; // Calculate vertical center of the page

    rowMarks.forEach((div) => {
        const divRect = div.getBoundingClientRect();
        const divCenter = (divRect.top + divRect.bottom) / 2; // Calculate center of the bounding box

        const verticalDistance = Math.abs(divCenter - verticalCenter);
        if (verticalDistance < minVerticalDistance) {
            closestDiv = div;
            minVerticalDistance = verticalDistance;
        }
    });

    return closestDiv.id;
}

var csrfToken = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");

function enterPageBuild(page, sentBy, rowId) {
    var returnPage = page;
    if (sentBy === "build") {
        var pathname = window.location.pathname;
        var parts = pathname.split("/");
        returnPage = parts[parts.length - 1];
    }

    window.location.href =
        "/session/build?" + page + "?" + returnPage + "?" + rowId;
}

function removeRowWarning(jItem) {
    item = JSON.parse(jItem);
    document.getElementById("main_modal_label").innerHTML = "确认删除此行 ";
    fetch("/delete_row_form")
        .then((response) => response.text())
        .then((html) => {
            modBody.innerHTML = html;
            document.getElementById("row_id").value = item.row.id;
            document.getElementById("page_id").value = item.page.id;
            document.getElementById("scroll_to").value = item.page.id;
        })
        .catch((error) =>
            console.error("Error loading remove nav item:", error)
        );
}
function markContactRead(id) {
    formName = "mark_contact_read_" + id;
    writeNoReturn(formName);
}
function showInquiry(id) {
    var bodies = document.querySelectorAll(".contact-body");
    bodies.forEach((body) => {
        body.style.display = "none";
        if (body.id === "inq_display" + id) {
            body.style.display = "block";
        }
    });
    var image = document.getElementById("read_contact" + id);
    image.setAttribute("src", iconsAsset + "glasses_white.svg");
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
