function logoFormFillout() {

    var form = document.getElementById("logo_edit");
    var div = form.parentElement;
    var logoText = document.getElementById("logo_text");
    var btn = document.getElementById("save_logo_btn");
    var logoToggle = document.getElementById("logoToggle");
    
    toggleLogoDisplay(logoToggle,btn);
    logoToggle.addEventListener("change", function () {
       toggleLogoDisplay(logoToggle,btn);
    });

    logoText.addEventListener("input", function (event) {
        applyLogoTitle(logoText, event);
    });
    var titleToggle = document.getElementById("title_Toggle");
    toggleTitleDisplay(titleToggle,logoText,btn)
    titleToggle.addEventListener("change", function () {
        toggleTitleDisplay(titleToggle,logoText,btn)
    });

    var uploadBars = div.querySelectorAll("#upload_file_bar_logo");
    var serverBars = div.querySelectorAll("#server_file_bar_logo");

    var serverLinks = div.querySelectorAll("#server_anchor_logo");
    var uploadLinks = div.querySelectorAll("#upload_anchor_logo");

    uploadInputs = uploadBars[0].querySelectorAll("#upload_logo");
    uploadInputs[0].addEventListener("change", (event) => {
        displayUploadedImages(null, uploadInputs[0], div);
    });
    serverInputs = serverBars[0].querySelectorAll("#server_logo");

    serverInputs[0].addEventListener("input", (event) => {
        displayServerFile(null, div, serverInputs[0].value);
    });

    serverBars[0].style.display = "none";

    uploadLinks[0].removeAttribute("style");
    uploadLinks[0].addEventListener("click", disableClick);
    serverLinks[0].addEventListener("click", () =>
        toggleOffLogoFiles(
            div,
            serverLinks[0],
            serverBars[0],
            uploadLinks[0],
            uploadBars[0]
        )
    );
    btn.setAttribute("style", "cursor:default");
    btn.classList.add("disabled");
}

function toggleTitleDisplay(titleToggle,logoText,btn)
{
    if (titleToggle.checked) {
        logoText.style.background = "";
    } else {
        logoText.style.background = "gray";
    }
   
    btn.setAttribute("style", "cursor:pointer");
    btn.classList.remove("disabled");
}

function toggleLogoDisplay(logoToggle,btn)
{
    var logoThumb = document.getElementById("logo_thumb");
    var logoUploadCtls = document.getElementById("logo_upload_ctls");
    if (logoToggle.checked) {
        logoThumb.classList.remove("hide-logo-element");
        logoThumb.classList.add("show-logo-element");
        logoUploadCtls.classList.remove("hide-logo-block");
        logoUploadCtls.classList.add("show-logo-block");
    } else {
        logoThumb.classList.remove("show-logo-element");
        logoThumb.classList.add("hide-logo-element");
        logoUploadCtls.classList.remove("hide-logo-block");
        logoUploadCtls.classList.add("hide-logo-block");
    }
   
    btn.setAttribute("style", "cursor:pointer");
    btn.classList.remove("disabled");
}

function submitLogoChange()
{
    var btn = document.getElementById("save_logo_btn");
    btn.setAttribute("style", "cursor:default");
    btn.classList.add("disabled");
    writeNoReturn("logo_edit")
}
function applyLogoTitle(input) {
    var sendTitle = document.getElementById("send_logo_title");
    sendTitle.value = input.value;
    if (input.value.trim() === "") {
        input.style.background = "gray";
    } else {
        input.style.background = "";
    }
    var btn = document.getElementById("save_logo_btn");
    btn.setAttribute("style", "cursor:pointer");
    btn.classList.remove("disabled");
}

function toggleOnLogoFiles(div, serverLink, serverBar, uploadLink, uploadBar) {
    const serverIcons = div.querySelectorAll("#server_icon_logo");
    const uploadIcons = div.querySelectorAll("#upload_icon_logo");

    // Toggle off the uploadLink
    uploadLink.setAttribute("style", "cursor:default");
    uploadLink.removeEventListener("click", toggleOffLogoFiles);
    uploadLink.addEventListener("click", disableClick);

    // Toggle on the serverLink
    serverLink.addEventListener("click", () =>
        toggleOffLogoFiles(div, serverLink, serverBar, uploadLink, uploadBar)
    );
    serverLink.setAttribute("style", "cursor:pointer");
    // Update icons and bars
    serverIcons[0].setAttribute("src", iconsAsset + "/server.svg");
    uploadIcons[0].setAttribute("src", iconsAsset + "/upload_green.svg");
    serverBar.style.display = "none";
    uploadBar.style.display = "block";
}

function toggleOffLogoFiles(div, serverLink, serverBar, uploadLink, uploadBar) {
    const serverIcons = div.querySelectorAll("#server_icon_logo");
    const uploadIcons = div.querySelectorAll("#upload_icon_logo");
    // Toggle off the serverLink
    serverLink.setAttribute("style", "cursor:default");
    serverLink.removeEventListener("click", toggleOnLogoFiles);
    serverLink.addEventListener("click", disableClick);

    // Toggle on the uploadLink
    uploadLink.addEventListener("click", () =>
        toggleOnLogoFiles(div, serverLink, serverBar, uploadLink, uploadBar)
    );
    uploadLink.setAttribute("style", "cursor:pointer");

    // Update icons and bars
    uploadIcons[0].setAttribute("src", iconsAsset + "/upload.svg");
    serverIcons[0].setAttribute("src", iconsAsset + "/server_green.svg");
    serverBar.style.display = "block";
    uploadBar.style.display = "none";
}
