function articleFormRouter(formName, item) {
    console.log("to fillout article??");
    if (formName === "edit_text_article") {
        titleTextFillout(formName, item);
    }
}

function titleTextFillout(formName, jItem) {
    var item = JSON.parse(jItem);

    addFieldAndValue(formName + "_title", item.article.title);
    addFieldAndValue(formName + "_body", removeHtmlTags(item.article.body));
    addFieldAndValue("article_id", item.article.id);
    addFieldAndValue("row_id", item.rowId);
    addFieldAndValue("page_id", item.pageId);
    addFieldAndValue("scroll_to", item.index);

    var style = item.article.styles["title"];

   var titleStyle = document.getElementById("edit_text_article_title");

    var sizeSelect = document.getElementById("size_select");
    
    var match = style.match(/t(\d+)/)[1];
    console.log("style: " + match);
    sizeSelect.value = match.toString();

    sizeSelect.addEventListener("change", function () {
        setTitleHeight(sizeSelect.value);
    });
    titleStyle.className= "form-control t"+match;
    tinymce.init({
        selector: "#" + formName + "_body",
        plugins: "advlist autolink lists link image charmap  preview",
        toolbar:
            "undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | link",
        menubar: false,
        promotion: false,
        license_key: "gpl",
    });
    var showInfo = document.getElementById("article_info_div");
  var showRadio = document.getElementById("info-radio");

    var useInfo  = document.querySelector('#inlineCheckbox1');
    var infoStyle = item.article.styles["info"];
    if (infoStyle != "on") {
        showInfo.classList.add("hide-info-link");
        showRadio.classList.add("hide-info-link");
    }
    else{
        useInfo.checked =true;
    }
    useInfo.addEventListener("change", function () {
        console.log("changed check");
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
    
    var div = document.getElementById('rowInsert'+item.rowId)
   
    var sequence = "update_article^"+item.pageId+"^"+ item.rowId;
    saveBtn.onclick = function () {
        if (verifySubmit(saveBtn)) {
            writeAndRender(formName, sequence, div);
        }
    };
}

function removeHtmlTags(input) {
    return input.replace(/<\/?[^>]+(>|$)/g, "");
}

function setTitleHeight(selectedOption) {
    var articleTitle = document.getElementById("edit_text_article_title");
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
