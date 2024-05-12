function insertImageEditor(item) {
    jItem = JSON.parse(item);
    const div = document.getElementById("image_" + jItem.rowId);
    var sequence = "refresh_/image_refresh";
    refreshDiv(div, sequence)
        .then(() => {
            setIconsBar(div, jItem);
        })
        .catch((error) => {
            console.error("Error refreshing page:", error);
        });
}

function imageFormFillout(formName, item) {
    jItem = JSON.parse(item);
    const form = document.getElementById(formName);
    const div = form.parentElement;
    const colId = document.getElementById("image_column_id");
    colId.value = jItem.id;
    form.addEventListener("submit", function (event) {
        submitUpdateRequest(form, jItem, formName, div, event);
    });

    setImageAndCorners(div, jItem);
    const uploadBars = div.querySelectorAll("#upload_file_bar");
    const serverBars = div.querySelectorAll("#server_file_bar");

    const serverLinks = div.querySelectorAll("#server_anchor");
    const uploadLinks = div.querySelectorAll("#upload_anchor");

    uploadInputs = uploadBars[0].querySelectorAll("#upload");
    uploadInputs[0].addEventListener("change", (event) => {
        displayUploadedImages(null, uploadInputs[0], div);
    });
    serverInputs = serverBars[0].querySelectorAll("#server");

    serverInputs[0].addEventListener("input", (event) => {
        displayServerFile(null, div, serverInputs[0].value);
    });

    serverBars[0].style.display = "none";

    uploadLinks[0].removeAttribute("href");
    uploadLinks[0].addEventListener("click", disableClick);
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
    captions[0].value = jItem.body;

}
// function setCusomSubmitImg(formName, item, div, key) {
//     const form = document.getElementById(formName);
//     if (formName === "nav_dropdown") {
//         item = item.nav;
//     }
//     form.addEventListener("submit", function (event) {
//         submitUpdateRequest(form, item, formName, div, event, key);
//     });
// }

function setImageAndCorners(div, item) {
    const thumbs = div.querySelectorAll("#thumb");
    thumbs[0].setAttribute("src", imagesAsset + item.image);
    var imgField = document.getElementById("image_name");
    imgField.value = item.image;
    const icons = div.querySelectorAll(".corner");
    const style = item.styles["corners"];
    if (style == "image-thumb-rounded") {
        thumbs[0].classList.add(style);
        icons.forEach((icon) => {
            if (icon.id === style) {
                icon.classList.add("selected");
            }
        });
    } else if (style == "rounded-circle") {
        thumbs[0].classList.add(style);
        icons.forEach((icon) => {
            if (icon.id === style) {
                icon.classList.add("selected");
            }
        });
    }
    const radioInputs = div.querySelectorAll(".corner");
    radioInputs.forEach((icon) => {
        icon.addEventListener("click", function () {
            setCornersStyle(this.id, div);
        });
    });
    console.log("STLY WAS: " + style);
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
            // const fileElement = document.getElementById("file_capture_" + slideId);
            // fileElement.value = "";
            updateSlideData();
        } else {
            var imgField = document.getElementById("image_name");
            imgField.value = imageName;
        }
    }
}
function displaySelectedFile22(id, imageName) {
    if (imageName != "选择一个文件...") {
        const imgElement = getImageElementFromCard(id);
        if (imgElement) {
            imgElement.src = imagesAsset + imageName;
        }
        var slide = slideShowItems[id];
        slide.source = "server";
        slide.image = imageName;
        slide.file = null;
        // const fileElement = document.getElementById("file_capture_" + slideId);
        // fileElement.value = "";
        updateSlideData();
    }
}
function displayUploadedImages(id, input, div) {
    const imgElement = div.querySelector("#thumb");
    const file = input.files[0];
    const reader = new FileReader();
    reader.onload = function (event) {
        imgElement.src = event.target.result;
    };
    reader.readAsDataURL(file);
    if (id) {
        var slide = slideShowItems[id];
        slide.image = file.name;
        slide.file = file;
        slide.source = "upload";
        updateSlideData();
    } else {
        var imgField = document.getElementById("image_name");
        imgField.value = file.name;
    }
}
function disableClick(event) {
    event.preventDefault();
}

function toggleOn(div, serverLink, serverBar, uploadLink, uploadBar) {
    const serverIcons = div.querySelectorAll("#server_icon");
    const uploadIcons = div.querySelectorAll("#upload_icon");

    // Toggle off the uploadLink
    uploadLink.removeAttribute("href");
    uploadLink.removeEventListener("click", toggleOff);
    uploadLink.addEventListener("click", disableClick);

    // Toggle on the serverLink
    serverLink.addEventListener("click", () =>
        toggleOff(div, serverLink, serverBar, uploadLink, uploadBar)
    );
    serverLink.setAttribute("href", "#");

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
    serverLink.removeAttribute("href");
    serverLink.removeEventListener("click", toggleOn);
    serverLink.addEventListener("click", disableClick);

    // Toggle on the uploadLink
    uploadLink.addEventListener("click", () =>
        toggleOn(div, serverLink, serverBar, uploadLink, uploadBar)
    );
    uploadLink.setAttribute("href", "#");

    // Update icons and bars
    uploadIcons[0].setAttribute("src", iconsAsset + "/upload.svg");
    serverIcons[0].setAttribute("src", iconsAsset + "/server_green.svg");
    serverBar.style.display = "block";
    uploadBar.style.display = "none";
}
