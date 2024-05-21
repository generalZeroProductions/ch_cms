function setupFormSubmit(formName, sequence, div) {
    var title = document.getElementById(formName + "_title");
    title.addEventListener("input", function (event) {
        validateTitle(formName, title, event);
    });
    title.addEventListener("blur", function () {
        title.removeEventListener("keydown", handleKeyDown);
    });
    title.addEventListener("focus", function () {
        title.addEventListener("keydown", handleKeyDown);
    });

    var btn = document.getElementById(formName + "_btn");
    btn.onclick = function () {
        if (verifySubmit(btn)) {
            writeAndRender(formName, sequence, div);
        }
    };
}

function enableSubmit(formName) {
    console.log("ENABLING ");
    var btn = document.getElementById(formName + "_btn");
    var title = document.getElementById(formName + "_title");
    if (title.value != "") {
        btn.classList.remove("disabled");
    }
}
function enableTabSubmit() {
    var btn = document.getElementById("edit_tabs_btn");
    btn.classList.remove("disabled");
}

function disableSubmit(formName) {
    var btn = document.getElementById(formName + "_btn");
    btn.classList.add("disabled");
}

function validateTitle(formName, title, event) {
    var text = event.target.value;
    var text = event.target.value.trim();
    if (text === "") {
        title.style.backgroundColor = "rgb(241, 78, 78)";
        title.placeholder = "该项目必须有标题";
        disableSubmit(formName);
    } else {
        if (formName === "dropdown_editor_nav") {
            if (hasMenuItems()) {
                title.style.backgroundColor = "";
                enableSubmit(formName);
            }
        } else {
            title.style.backgroundColor = "";
            enableSubmit(formName);
        }
    }
}

function validateTabTitle(title, event) {
    var text = event.target.value;
    var text = event.target.value.trim();
    if (text === "") {
        title.style.backgroundColor = "rgb(241, 78, 78)";
        title.placeholder = "项卡必须有标题";
        disableSubmit("edit_tabs");
    } else {
        title.style.backgroundColor = "";
        enableTabSubmit();
    }
}

function hasTabs() {
    var allInputs = document.querySelectorAll(".tab-title");
    var inputsArray = Array.from(allInputs);
    return inputsArray.some((element) => {
        var text = element.value.trim();
        if (text != "") {
            return true;
        }
    });
}

function validateForm(newInput, event) {
    var text = event.target.value;
    var text = event.target.value.trim();
    if (text === "") {
        newInput.style.backgroundColor = "rgb(241, 78, 78)";
        newInput.placeholder = "该项目必须有标题";
        disableSubmit("dropdown_editor_nav");
    } else {
        newInput.style.backgroundColor = "";
        newInput.placeholder = "";
        enableSubmit("dropdown_editor_nav");
    }
}

function hasMenuItems() {
    var allInputs = document.querySelectorAll(".subItemInput");
    var inputsArray = Array.from(allInputs);
    return inputsArray.some((element) => {
        var text = element.value.trim();
        if (text != "") {
            return true;
        }
    });
}

function handleKeyDown(event) {
    if (event.key === "Enter" || event.keyCode === 13) {
        console.log("Enter key was pressed");
    }
}

function verifySubmit(btn) {
    if (btn.classList.contains("disabled")) {
        return false;
    } else {
        return true;
    }
}
