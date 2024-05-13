function articleFormRouter(formName, item){
    if(formName==='edit_title_text')
    {
        titleTextFillout(formnName, jItem);
    }

}

function titleTextFillout(formnName, jItem) {
    var item = JSON.parse(jItem);

    addFieldAndValue(formnName + "_title", removeHtmlTags(item.article.title));
    addFieldAndValue(formnName + "_body", removeHtmlTags(item.article.body));
    addFieldAndValue("article_id", removeHtmlTags(item.article.id));
    addFieldAndValue("row_id", removeHtmlTags(item.rowId));

    var cancelBtn = document.getElementById("cancel_article");

    var sizeSelect = document.getElementById("size_select");
    var selectedOptionNumber = parseInt(
        item.article.title.match(/<h(\d+)>/)[1]
    );
    sizeSelect.value = selectedOptionNumber.toString();

    sizeSelect.addEventListener("change", function () {
        setTitleHeight(sizeSelect.value);
    });
    tinymce.init({
        selector: "#" + formnName + "_body",
        plugins: "advlist autolink lists link image charmap  preview",
        toolbar:
            "undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | link",
        menubar: false,
        promotion: false,
        license_key: "gpl",
    });
}

function removeHtmlTags(input) {
    return input.replace(/<\/?[^>]+(>|$)/g, "");
}

function setTitleHeight(selectedOption) {
    var articleTitle = document.getElementById("article_title");
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
