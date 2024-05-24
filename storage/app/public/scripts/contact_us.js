function setupContactForm() {
    var noName = document.getElementById("no_name");
    if (!noName) {
        return;
    }
    var noMessage = document.getElementById("no_message");
    var noContact = document.getElementById("no_contact");
    var nameText = document.getElementById("name");
    nameText.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
        }
    });
    nameText.addEventListener("input", function (event) {
        if (nameText.value.trim() != "") {
            noName.style.display = "none";
        }
    });
    var contactText = document.getElementById("contact_info");
    contactText.addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
        }
    });
    contactText.addEventListener("input", function (event) {
        if (contactText.value.trim() != "") {
            noContact.style.display = "none";
        }
    });
    var messageText = document.getElementById("message_body");
    messageText.addEventListener("input", function (event) {
        if (messageText.value.trim() != "") {
            noMessage.style.display = "none";
        }
    });

    var contactType = document.getElementById("contact_type");
    var initialButton = document.querySelector(".btn-group .btn.active");

    if (initialButton) {
        contactType.value = initialButton.value;
    }
    document
        .querySelector(".btn-group .btn:first-child")
        .classList.add("active");
    document.querySelectorAll(".btn-group .btn").forEach(function (b) {
        b.addEventListener("click", function () {
            document
                .querySelectorAll(".btn-group .btn")
                .forEach(function (btn) {
                    btn.classList.remove("active");
                    contactType.value = b.value;
                });
            this.classList.add("active");
        });
    });

    var button = document.getElementById("submit_contact_btn");
    console.log("adding event listener");

    button.addEventListener("click", function (event) {
        var valid = true;
        if (nameText.value.trim() === "") {
            valid = false;
            noName.style.display = "block";
        }
        if (messageText.value.trim() === "") {
            valid = false;
            noMessage.style.display = "block";
        }
        if (contactText.value.trim() === "") {
            valid = false;
            noContact.style.display = "block";
        }
        if (valid) {
            console.log("BUTTON CLICK HERE");
            var div = document.getElementById("contact_us_div");
            writeAndRender("client_contact_form", "联系我们", div);
        }
    });
}

function editContactSetup(formName, tStyle) {
    console.log(tStyle + "THATS WHAT YOU SNET");
    var editContactDiv = document.getElementById(formName + "_editor");
    editContactDiv.style.display = "block";
    var textFields = [];
    var title = document.getElementById("edit_" + formName + "_title");
    textFields.push(title);
    if (formName === "contact") {
        var type1 = document.getElementById("contact_type_1");
        textFields.push(type1);
        var type2 = document.getElementById("contact_type_2");
        textFields.push(type2);
        var type3 = document.getElementById("contact_type_3");
        textFields.push(type3);
        var nameText = document.getElementById("name_head");
        textFields.push(nameText);
        var nameWarn = document.getElementById("name_warn");
        textFields.push(nameWarn);
        var contentText = document.getElementById("contact_head");
        textFields.push(contentText);
        var contentWarn = document.getElementById("contact_warn");
        textFields.push(contentWarn);
        var messageText = document.getElementById("message_label");
        textFields.push(messageText);
        var messageText = document.getElementById("message_label");
        textFields.push(messageText);
        var messageWarn = document.getElementById("message_warn");
        textFields.push(messageWarn);
    }

    textFields.forEach((field) => {
        field.addEventListener("keypress", function (event) {
            if (event.key === "Enter") {
                event.preventDefault();
            }
        });
        field.addEventListener("focus", function (event) {
            field.style.backgroundColor = "";
            field.placeholder = "";
        });
    });

    var sizeSelect = document.getElementById("size_select_" + formName);
    var match = tStyle.match(/t(\d+)/)[1];
    sizeSelect.value = match.toString();
    sizeSelect.addEventListener("change", function () {
        setTitleHeight(sizeSelect.value, "edit_" + formName + "_title");
    });
    title.className = "form-control t" + match;

    var btn = document.getElementById("submit_" + formName + "_update");
    btn.addEventListener("click", function (event) {
        // Prevent the default form submission behavior
        event.preventDefault();
        var valid = true;
        textFields.forEach((field) => {
            if (field.value.trim() === "") {
                field.style.backgroundColor = "rgb(241, 78, 78)";
                valid = false;
                field.placeholder = "字段不能为空";
            }
        });
        if (valid) {
            writeNoReturn("update_" + formName + "_form");
        }
    });
}

function deleteContact(id) {}
