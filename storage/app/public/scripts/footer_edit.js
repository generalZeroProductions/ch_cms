footerDataList = [];
deleteFooterList = [];
footIds = -1;

function changeFooterSetup(type) {
    console.log("calling footer here " + type);
    var singleSelect = document.getElementById("single_footer_click");
    var doubleSelect = document.getElementById("double_footer_click");
    if (type === "double") {
        doubleSelect.classList.remove("blue-bar");
        doubleSelect.classList.add("blue-bar-on");
        singleSelect.setAttribute("onclick", "switchToSingle()");
    } else {
        singleSelect.classList.remove("blue-bar");
        singleSelect.classList.add("blue-bar-on");
        doubleSelect.setAttribute("onclick", "switchToDouble()");
    }
}

function switchToSingle() {
    var div = document.getElementById("site_footer");
    writeAndRender("single_footer_form", "footer", div);
}
function switchToDouble() {
    var div = document.getElementById("site_footer");
    writeAndRender("double_footer_form", "footer", div);
}

function footerFillout(formName, jItem) {
    footIds = -1;
    footerDataList = [];
    deleteFooterList = [];
    var item = JSON.parse(jItem);

    item.items.forEach((footer) => {
        newFooterFromSource(footer);
    });
    updateFooterData();
    var btn = document.getElementById("sumbit_edit_footer");
    var div = document.getElementById("site_footer");

    btn.onclick = function () {
       footerDataList.forEach(record => {
        console.log(record.body);
        var text = record.body;
        record.body = decodeHTML(text);
       });
        writeAndRender("edit_footer_item", "footer", div);
    };
}

function newFooterFromSource(footer) {
    var foot = {
        record: true,
        id: footer.id,
        body: decodeHTML(decodeURIComponent(footer.body)),
        name: "editableDiv" + footer.id,
        index: footer.index,
    };
    footerDataList.push(foot);
    createEditableDiv(footer);
}
function newFooter() {
    var foot = {
        record: false,
        id: null,
        body: "new footer item",
        name: "editableDiv" + footIds,
        index: footerDataList.length,
    };
    footIds--;
    footerDataList.push(foot);
    createEditableDiv(foot);
    updateFooterData();
}
function decodeHTML(html) {
    var txt = document.createElement("textarea");
    txt.innerHTML = html;
    var send = txt.value;
    txt.remove();
    return send;
}
function createEditableDiv(footer) {
    var footDiv = document.getElementById("footer_items_list");
    var editableDiv = document.createElement("div");
    editableDiv.contentEditable = "true";
    // var htmBody = decodeURIComponent(footer.body);
     var getDecode = decodeHTML(footer.body);
    // editableDiv.insertAdjacentHTML("beforeend",footer.body);
    editableDiv.innerHTML = getDecode;
    editableDiv.id = "editableDiv" + footer.id;
    editableDiv.className = "p-2";
    editableDiv.style.border = "1px solid black";
    editableDiv.style.minHeight = "36px";
    editableDiv.style.fontSize = "13px";
    editableDiv.style.marginTop = "6px";
    footDiv.appendChild(editableDiv);
    editableDiv.addEventListener("input", function (event) {
        writeFooterBody(editableDiv.id);
    });
}
function writeFooterBody(divId) {
    console.log("AT WRITE ")
    var div = document.getElementById(divId);
    var index = footerDataList.findIndex((item) => item.name === divId);
    footerDataList[index].body = div.innerHTML;
    var show = document.getElementById("show_me_ht");
    show.innerHTML = footerDataList[index].body;
    updateFooterData();
}

function deleteFooter() {
    var footer = footerDataList[footerDataList.length - 1];
    var divRemove = document.getElementById(footer.name);
    divRemove.remove();
    deleteFooterList.push(footer);
    footerDataList.splice(footerDataList.length - 1, 1);
    var hiddenField = document.getElementById("delete_footer_data");
    hiddenField.value = JSON.stringify(deleteFooterList);
    updateFooterData();
}

function updateFooterData() {
    var hiddenField = document.getElementById("store_footer_data");
    console.log(footerDataList[0].body)
    hiddenField.value = JSON.stringify(footerDataList);
    console.log(hiddenField.value);
    var trash = document.getElementById("delete_footer");
    if (footerDataList.length === 1) {
        trash.style.visibility = "hidden";
    } else {
        trash.style.visibility = "visible";
    }
}
