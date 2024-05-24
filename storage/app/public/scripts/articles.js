function articleFormRouter(formName, item) {
    console.log("to fillout article??");
    if (formName === "edit_text_article") {
        titleTextFillout(formName, item);
    }
}

function titleTextFillout(formName, jItem) {
    var item = JSON.parse(jItem);
    editingDiv = null;
    addFieldAndValue(formName + "_title", item.article.title);

    var editDiv = document.getElementById("htmlDiv");
    editingDiv = editDiv;
    editDiv.insertAdjacentHTML("beforeend", item.body);

    editDiv.addEventListener("input", function (event) {
        console.log("LISTENING");
        updateHtmlDivString();
    });
 
    addFieldAndValue("article_id", item.article.id);
    addFieldAndValue("row_id", item.rowId);
    addFieldAndValue("page_id", item.pageId);
    addFieldAndValue("scroll_to", item.rowId);

    var style = item.article.styles["title"];

    var titleStyle = document.getElementById("edit_text_article_title");

    var sizeSelect = document.getElementById("size_select");

    var match = style.match(/t(\d+)/)[1];

    sizeSelect.value = match.toString();

    sizeSelect.addEventListener("change", function () {
        setTitleHeight(sizeSelect.value,'edit_text_article_title');
    });
    titleStyle.className = "form-control t" + match;

    var showInfo = document.getElementById("article_info_div");
    var showRadio = document.getElementById("info-radio");

    var useInfo = document.querySelector("#inlineCheckbox1");
    var infoStyle = item.article.styles["info"];
    if (infoStyle != "on") {
        showInfo.classList.add("hide-info-link");
        showRadio.classList.add("hide-info-link");
    } else {
        useInfo.checked = true;
    }
    useInfo.addEventListener("change", function () {
        if (useInfo.checked) {
            showInfo.classList.remove("hide-info-link");
            showInfo.classList.add("show-info-link");
            showRadio.classList.remove("hide-info-link");
            showRadio.classList.add("show-info-link");
        } else {
            showInfo.classList.remove("show-info-link");
            showInfo.classList.add("hide-info-link");
            showRadio.classList.remove("show-info-link");
            showRadio.classList.add("hide-info-link");
        }
    });

    var infoStyle = item.info.styles["type"];
    if (infoStyle === "button") {
        document.getElementById("radio_button").checked = true;
    } else {
        document.getElementById("radio_link").checked = true;
    }
    var routeSelect = document.getElementById("route_select");
    allRoutes.forEach(function (page) {
        var option = document.createElement("option");
        option.value = page;
        option.text = page;
        if (page === item.route) {
            option.selected = true;
        }
        routeSelect.appendChild(option);
    });
    var saveBtn = document.getElementById("edit_article_btn");
    var cancelBtn = document.getElementById("cancel_article");
    var infoTitle = document.getElementById("article_info_title");

    infoTitle.value = item.info.title;
    infoTitle.addEventListener("input", function (event) {
        validateInfoTitle(infoTitle, saveBtn);
    });

    var div = document.getElementById("rowInsert" + item.rowId);
  
    var sequence = "update_article^" + item.pageId + "^" + item.rowId;
    saveBtn.onclick = function () {
        if (verifySubmit(saveBtn)) {
            writeAndRender(formName, sequence, div,[]);
        }
    };
    updateHtmlDivString();
}

function removeHtmlTags(input) {
    return input.replace(/<\/?[^>]+(>|$)/g, "");
}

function setTitleHeight(selectedOption, field) {
    var articleTitle = document.getElementById(field);
    var selectedClass = "form-control"; // Start with 'form-control'
    if (selectedOption === "1") {
        selectedClass += " t1";
    } else if (selectedOption === "2") {
        selectedClass += " t2";
    } else if (selectedOption === "3") {
        selectedClass += " t3";
    } else if (selectedOption === "4") {
        selectedClass += " t4";
    } else if (selectedOption === "5") {
        selectedClass += " t5";
    }
    articleTitle.className = selectedClass;
}

function validateInfoTitle(title, btn) {
    var text = title.value.trim();
    if (text === "") {
        title.style.backgroundColor = "rgb(241, 78, 78)";
        title.placeholder = "不能将字段留空";
        btn.classList.add("disabled");
    } else {
        title.style.backgroundColor = "";
        title.placeholder = "";
        btn.classList.remove("disabled");
    }
}
function boldSelected(route) {
    const selection = window.getSelection();
    const range = selection.getRangeAt(0);
    const span = document.createElement("span");
    span.style.fontWeight = 800;
    range.surroundContents(span);
    if(route==='article')
    {
        updateHtmlDivString();
    }
    else{
        var div = findContainerDiv(range.startContainer);
        writeFooterBody(div.id);
    }
    
}
function unboldSelected(route) {
    const selection = window.getSelection();
    const range = selection.getRangeAt(0);
    const span = document.createElement("span");
    span.style.fontWeight = 600;
    if(route==='article')
    {
        span.style.fontWeight = 400;
    }
    range.surroundContents(span);
    updateHtmlDivString();
    if(route==='article')
    {
        updateHtmlDivString();
    }
    else{
        var div = findContainerDiv(range.startContainer);
        writeFooterBody(div.id);
    }
}


var editingDiv;
function addLink() {
    console.log("called");
    const selection = window.getSelection();
    const range = selection.getRangeAt(0);
    editingDiv =findContainerDiv(range.startContainer);
    openLinkModal(range);
}

function openLinkModal(range) {
    $("#linkModal").modal("show");
    window.range = range; // Store the range in a global variable
}

function saveLink() {
    var hrefInput = document.getElementById("hrefInput");
    const hrefValue = hrefInput.value;

    if (hrefValue && window.range) {
        // Check if range is defined
        const range = window.range; // Get the range from the global variable
        const link = document.createElement("a");
        link.href = hrefValue; // Set the href value provided by the user
        link.textContent = range.toString();
        range.deleteContents();
        range.insertNode(link);
        updateHtmlDivString();
    }
    $("#linkModal").modal("hide"); // Hide the modal after saving
}
function updateHtmlDivString() {
   
    // const htmlDiv = document.getElementById("htmlDiv");
    // htmlDivStringInput.value = htmlDiv.innerHTML;
    if(editingDiv)
    {
        console.log("WE ARE DINDNG THE DUDE");
        if(editingDiv.id === "htmlDiv")
        {
            var htmlDivStringInput = document.getElementById("htmlDivString");
            htmlDivStringInput.value = editingDiv.innerHTML;

        }
        else{
            writeFooterBody(editingDiv.id);
        }
       
    }

}

function findContainerDiv(node) {
    while (
        node &&
        node.tagName !== "DIV" 
    ) {
        node = node.parentNode;
    }
    console.log("node is "+node.id);
    return node;
}

function removeLink(route) {
    const selection = window.getSelection();
    var useRange = null;
    if (!selection.isCollapsed) {
        const range = selection.getRangeAt(0);
        useRange = selection.getRangeAt(0);
        const link = range.commonAncestorContainer.parentNode.closest("a");
        if (link) {
            const text = document.createTextNode(link.textContent);
            link.parentNode.insertBefore(text, link);
            link.parentNode.removeChild(link);
        }
        if(route==='article')
        {
            updateHtmlDivString();
        }
        else{
            var div = findContainerDiv(range.startContainer);
            writeFooterBody(div.id);
        }
    }
   
}
