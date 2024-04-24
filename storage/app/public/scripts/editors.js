var slideShowItems = [];
var previewList;


function editSlidesForm(divId, location, slideList) {
    slideShowItems = [];
    const slideDiv = document.getElementById(divId);
    const parseSlides = JSON.parse(slideList);
    const locItem = JSON.parse(location);
    parseSlides.forEach((slide) => {
        createNewSlide(slide);
    });

    fetch("/slideShowEdit")
        .then((response) => response.text())
        .then((html) => {
            slideDiv.innerHTML = html;
            document.getElementById("row_id").value = locItem.row.id;
            document.getElementById("page_id").value = locItem.page.id;
            initializeSlideshowEditor();
            showSlideshowPreview();
            var runScriptsDiv = document.getElementById("run_scripts");
            if (runScriptsDiv) {
                var innerHtml = runScriptsDiv.innerHTML;
                var toolTipCall = innerHtml.match(/toolTipStart\([^)]*\)/);
                if (toolTipCall !== null) {
                    eval(toolTipCall[0]);
                }
            }
        })
        .catch((error) => {
            console.error("Error loading slideshowEdit:", error);
        });
}


function initializeSlideshowEditor() {
    for (let i = 0; i < 6; i++) {
        const captionId = "caption_capture" + i;
        const captionElement = document.getElementById(captionId);
        captionElement.addEventListener("change", function (event) {
            var caption = event.target.value;
            updateSlideCaption(i, { caption: caption });
        });
        const fileId = "file_capture_" + i;
        const fileElement = document.getElementById(fileId);
        if(!fileElement){console.log("no file element");}
        fileElement.addEventListener("change", (event) => {
            const selectedFile = event.target.files[0];
            displayUploadedImage(i);
        });
        const selectID = "image_capture_" + i;
        const selectElement = document.getElementById(selectID);
        if(!selectElement){console.log("no select element");}
        selectElement.addEventListener("change", (event) => {
            var image = event.target.value;
            changeSlideImage(i, image);
        });
    }
    updateSlideData();
}
function displayUploadedImage(slideId) {
    const thumbId = "thumb_" + slideId;
    const thumbElement = document.getElementById(thumbId);
    const imgElement = thumbElement.querySelector("img");
    const fileElement = document.getElementById("file_capture_" + slideId);
    const file = fileElement.files[0];
    const reader = new FileReader();
    reader.onload = function (event) {
        imgElement.src = event.target.result;
    };
    reader.readAsDataURL(file);
    var slide = slideShowItems[slideId];
    slide.image = file.name;
    slide.file = file;
    slide.source = "upload";

    updateSlideData();
}

function updateSlideCaption(slideId, caption) {
    var slide = slideShowItems[slideId];
    slide.caption = caption;
    updateSlideData();
}

function updateSlideData() {
    var slideData = document.getElementById("slide_show_data");
    console.log(slideShowItems);
    updateData = JSON.stringify(slideShowItems); // Assuming 'data' is the ID of the hidden field
    slideData.value = updateData; // Convert the object to a JSON string and set it as the value of the hidden field
}

function changeSlideImage(slideId, image) {
    var slide = slideShowItems[slideId];
    slide.source = "server";
    slide.image = image;
    slide.file = null;
    var thumbElement = document.getElementById("thumb_" + slideId);
    const imgElement = thumbElement.querySelector("img");
    if (imgElement) {
        imgElement.src = imagesAsset + image;
    }
    const fileElement = document.getElementById("file_capture_" + slideId);
    fileElement.value = "";
    updateSlideData();
}

function deleteItemAtIndex(slide) {
    slideShowItems.splice(slide, 1);
    for (let i = slide; i < slideShowItems.length; i++) {
        slideShowItems[i].index--;
    }
    updateSlideData();
    showSlideshowPreview();
  }

function createNewSlide(slide) {
    if (slide === null) {
        var newSlide = {
            id: slideShowItems.length,
            source: "server",
            image: "defaultBanner.jpg",
            file: null,
            caption: "Enter Caption Here",
            record:null
        };
        slideShowItems.push(newSlide);
        updateSlideData();
        showSlideshowPreview();
        
    } else {
        var newSlide = {
            id: slideShowItems.length,
            source: "server",
            image: slide.image,
            file: null,
            caption: slide.caption,
            record:slide.record
        };
        slideShowItems.push(newSlide);
    }
}

function showUploadElement(i)
{
    const editorId = "edit_icons_" + i;
        const editElement = document.getElementById(editorId);
        const fileId = "file_input_" + i;
        const fileElement = document.getElementById(fileId);
        const selectID = "image_select_" + i;
        const selectElement = document.getElementById(selectID);
        editElement  && (editElement.style.display = "none");
        selectElement  && (selectElement.style.display = "none");
        fileElement  && (fileElement.style.display = "block");
}

function showSelectElement(i)
{
    const editorId = "edit_icons_" + i;
        const editElement = document.getElementById(editorId);
        const fileId = "file_input_" + i;
        const fileElement = document.getElementById(fileId);
        const selectID = "image_select_" + i;
        const selectElement = document.getElementById(selectID);
        editElement  && (editElement.style.display = "none");
        selectElement  && (selectElement.style.display = "block");
        fileElement  && (fileElement.style.display = "none");
}
function showEditElement(i)
{
        const editorId = "edit_icons_" + i;
        const editElement = document.getElementById(editorId);
        const fileId = "file_input_" + i;
        const fileElement = document.getElementById(fileId);
        const selectID = "image_select_" + i;
        const selectElement = document.getElementById(selectID);
        selectElement  && (selectElement.style.display = "none");
        fileElement  && (fileElement.style.display = "none");
        editElement  && (editElement.style.display = "block");
}

function showSlideshowPreview() {
    var listFinished = false;
    for (let i = 0; i < 6; i++) {
        const previewId = "preview_" + i;
        const previewElement = document.getElementById(previewId);
        const editorId = "edit_icons_" + i;
        const editElement = document.getElementById(editorId);
        const fileId = "file_input_" + i;
        const fileElement = document.getElementById(fileId);
        const selectID = "image_select_" + i;
        const selectElement = document.getElementById(selectID);
        const thumbId = "thumb_" + i;
        const thumbElement = document.getElementById(thumbId);
        const captionId = "caption_" + i;
        const captionElement = document.getElementById(captionId);
        const captionContentId = 'caption_capture' + i;
        const captionContentElement = document.getElementById(captionContentId);
        fileElement && (fileElement.style.display = "none");
        selectElement && (selectElement.style.display = "none");

        const addId = "add_" + i;
        const addElement = document.getElementById(addId);
        if (listFinished) {
            previewElement.style.display = "none";
        } else {
            previewElement.style.display = "block";
            var slide = slideShowItems[i];
            if (slide) {
                editElement  && (editElement.style.display = "block");
                thumbElement && (thumbElement.style.display = "block");
                captionElement && (captionElement.style.display = "block");
                const imgElement = thumbElement.querySelector("img");
                if (imgElement) {
                    if (slide.source === "server") {
                        imgElement.src = imagesAsset + slide.image;
                    } else {
                        if (slide.source == "upload") {
                            const reader = new FileReader();
                            reader.onload = function (event) {
                                imgElement.src = event.target.result;
                            };
                            reader.readAsDataURL(slide.file);
                        }
                    }
                }
                if (captionContentElement) {
                    captionContentElement.value = slide.caption;
                }
                addElement && (addElement.style.display = "none");
            } else {
                editElement && (editElement.style.display = "none");
                thumbElement && (thumbElement.style.display = "none");
                captionElement && (captionElement.style.display = "none");
                addElement && (addElement.style.display = "block");
                listFinished = true;
            }
        }
    }
}

