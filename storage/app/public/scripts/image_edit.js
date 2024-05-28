function imageFormFillout(formName_sent, jItem) {
    item = JSON.parse(jItem);
    var string = formName_sent;
    var formName = string.split("^")[0];
    var form = document.getElementById(formName);
    var div = form.parentElement;
    addFieldAndValue("row_id", item.rowId);
    addFieldAndValue("column_id", item.column.id);

    form.addEventListener("submit", function (event) {
        preventDefault();
    });
    setImageAndCorners(div, item);
    var uploadBars = div.querySelectorAll("#upload_file_bar");
    var serverBars = div.querySelectorAll("#server_file_bar");

    var serverLinks = div.querySelectorAll("#server_anchor");
    var uploadLinks = div.querySelectorAll("#upload_anchor");

    uploadInputs = uploadBars[0].querySelectorAll("#upload");
    uploadInputs[0].addEventListener("change", (event) => {
        displayUploadedImages(null, uploadInputs[0], div);
    });
    serverInputs = serverBars[0].querySelectorAll("#server");

    serverInputs[0].addEventListener("input", (event) => {
        displayServerFile(null, div, serverInputs[0].value);
    });

    serverBars[0].style.display = "none";
    uploadLinks[0].addEventListener("click", disableClick);
    serverLinks[0].setAttribute('style','cursor:pointer');
    serverLinks[0].addEventListener("click", () =>
        toggleOff(
            div,
            serverLinks[0],
            serverBars[0],
            uploadLinks[0],
            uploadBars[0]
        )
    );

    captions = div.querySelectorAll("#caption");
    captions[0].value = item.column.body;
    var rowDiv = document.getElementById("rowInsert" + item.rowId);
    var sequence =
        "img_edit^" + item.pageId + "^" + item.rowId + "^" + item.column.id;
    var btn = document.getElementById("img_edit_btn");
    btn.onclick = function () {
        writeAndRender(formName, sequence, rowDiv,[]);
    };
}

function setImageAndCorners(div, item) {
    const thumbs = div.querySelectorAll("#thumb");
    thumbs[0].setAttribute("src", imagesAsset + item.column.image);
    var imgField = document.getElementById("image_name");
    imgField.value = item.column.image;
    const icons = div.querySelectorAll(".corner");
    const style = item.column.styles["corners"];

    icons.forEach((icon) => {
        if (icon.id === style) {
            icon.classList.add("selected");
        }
        if (icon.id === "image_square") {
            if (!style) {
                icon.classList.add("selected");
            }
        }
    });
    if (style == "image-thumb-rounded") {
        thumbs[0].classList.add(style);
    } else if (style == "rounded-circle") {
        thumbs[0].classList.add(style);
    }
    const radioInputs = div.querySelectorAll(".corner");
    radioInputs.forEach((icon) => {
        icon.addEventListener("click", function () {
            setCornersStyle(this.id, div);
        });
    });

    var cornerField = document.getElementById("corners_field");
    cornerField.value = style;
}

function setCornersStyle(id, div) {
    const icons = div.querySelectorAll(".corner");
    const thumb = div.querySelectorAll("#thumb");
    icons.forEach((icon) => {
        if (icon.id === id) {
            icon.classList.add("selected", "border", "border-dark");
        } else {
            icon.classList.remove("selected", "border", "border-dark");
        }
        thumb[0].classList.remove("image-thumb-rounded", "rounded-circle");
        if (id === "rounded-circle") {
            thumb[0].classList.add(id);
        }
        if (id === "image-thumb-rounded") {
            thumb[0].classList.add(id);
        }
    });
    var cornerField = document.getElementById("corners_field");
    cornerField.value = id;
}

function displayServerFile(id, div, imageName) {
    if (imageName != "选择一个文件...") {
        const imgElement = div.querySelector("#thumb");
        imgElement.src = imagesAsset + imageName;
        if (id) {
            var slide = slideShowItems[id];
            slide.source = "server";
            slide.image = imageName;
            slide.file = null;
            var uploadElement = document.getElementById("upload_file");
            if(!uploadElement){
                uploadElement = document.getElementById("upload_file_bar_logo");
            }
            uploadElement.value = "";
            updateSlideData();
        } else {
            var imgField = document.getElementById("image_name");
            if (imgField) {
                imgField.value = imageName;
            }
            else{
                imgField = document.getElementById("logo_image_name");
                imgField.value = imageName;
                var btn = document.getElementById("save_logo_btn");
                btn.setAttribute("style", "cursor:pointer");
                btn.classList.remove("disabled");
            }
        }
    }
}

function displayUploadedImages(id, input, div) {
    const fileContainer = document.getElementById("fileContainer");
    const spinnerContainer = div.querySelectorAll("#spinnerContainer");
    spinnerContainer[0].style.display = "block";

    const imgElements = div.querySelectorAll("#thumb");
    const file = input.files[0];
    const reader = new FileReader();

    reader.onload = function (event) {
        spinnerContainer[0].style.display = "none";
        imgElements[0].src = event.target.result;
        if (id) {
            const slide = slideShowItems[id];
            slide.image = file.name;
            slide.file = file;
            slide.source = "upload";
            updateSlideData();
        } else {
            var imgField = document.getElementById("image_name");
            if (imgField) {
                imgField.value =  file.name;
            }
            else{
                imgField = document.getElementById("logo_image_name");
                imgField.value =  file.name;
                var btn = document.getElementById("save_logo_btn");
                btn.setAttribute("style", "cursor:pointer");
                btn.classList.remove("disabled");
            }
        }
    };
    reader.readAsDataURL(file);
}


function disableClick(event) {
    event.preventDefault();
}

function toggleOn(div, serverLink, serverBar, uploadLink, uploadBar) {
    const serverIcons = div.querySelectorAll("#server_icon");
    const uploadIcons = div.querySelectorAll("#upload_icon");

    // Toggle off the uploadLink
    
    uploadLink.setAttribute("style", "cursor:default");
    uploadLink.removeEventListener("click", toggleOff);
    uploadLink.addEventListener("click", disableClick);

    // Toggle on the serverLink
    serverLink.addEventListener("click", () =>
        toggleOff(div, serverLink, serverBar, uploadLink, uploadBar)
    );
 
    serverLink.setAttribute("style", "cursor:pointer");

    // Update icons and bars
    serverIcons[0].setAttribute("src", iconsAsset + "/server.svg");
    uploadIcons[0].setAttribute("src", iconsAsset + "/upload_green.svg");
    serverBar.style.display = "none";
    uploadBar.style.display = "block";
}

function toggleOff(div, serverLink, serverBar, uploadLink, uploadBar) {
    const serverIcons = div.querySelectorAll("#server_icon");
    const uploadIcons = div.querySelectorAll("#upload_icon");

    // Toggle off the serverLink
  
    serverLink.setAttribute('style', 'cursor:pointer')
    serverLink.removeEventListener("click", toggleOn);
    serverLink.addEventListener("click", disableClick);

    // Toggle on the uploadLink
    uploadLink.addEventListener("click", () =>
        toggleOn(div, serverLink, serverBar, uploadLink, uploadBar)
    );
    
    uploadLink.setAttribute("style", "cursor:pointer");
    // Update icons and bars
    uploadIcons[0].setAttribute("src", iconsAsset + "/upload.svg");
    serverIcons[0].setAttribute("src", iconsAsset + "/server_green.svg");
    serverBar.style.display = "block";
    uploadBar.style.display = "none";
}
