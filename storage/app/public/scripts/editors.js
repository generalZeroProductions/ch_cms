var slideShowItems = [];
var previewList;
var slideCount = 0;

function editSlidesForm(divId, row) {
    slideShowItems = [];
    const slideDiv = document.getElementById(divId);
    const parseRow = JSON.parse(row);
    var slideData = parseRow.data;
    slideData.slides.forEach((slide) => {
        createNewSlide(slide);
    });
    fetch("/slideShowEdit")
        .then((response) => response.text())
        .then((html) => {
            slideDiv.innerHTML = html;
            initializeSlideshowEditor();
            showSlideshowPreview();
        })
        .catch((error) => {
            console.error("Error loading slideshowEdit:", error);
        });
}

function initializeSlideshowEditor() {
    for (let i = 0; i < 6; i++) {
        const captionId = "caption_" + i;
        const captionElement = document.getElementById(captionId);
        captionElement.addEventListener("change", function (event) {
            var caption = event.target.value;
            updateSlideCaption(i, { caption: caption });
        });
        const fileId = "file_input_" + i;
        const fileElement = document.getElementById(fileId);
        fileElement.addEventListener("change", (event) => {
            const selectedFile = event.target.files[0];
            displayUploadedImage(i);
        });
        const selectImage = document.getElementById("image_select");
        const selectID = "image_select_" + i;
        const selectElement = document.getElementById(selectID);
        selectElement.addEventListener("change", (event) => {
            var selection = event.target.value;
            changeSlideImage(i, { image: selection });
        });
    }
}
function displayUploadedImage(slideId) {
    const thumbId = "thumb_" + slideId;
    const thumbElement = document.getElementById(thumbId);
    const imgElement = thumbElement.querySelector("img");
    const fileElement = document.getElementById("file_input_" + slideId);
    const file = fileElement.files[0];
    const reader = new FileReader();
    reader.onload = function (event) {
        imgElement.src = event.target.result;
    };
    reader.readAsDataURL(file);
    var slide = slideShowItems[slideId];
    slide.image = file.name;
    slide.upload = file;
    slide.display = "upload";

    updateSlideData();
}

function updateSlideCaption(slideId, caption) {
    var index = slideShowItems.findIndex((item) => item.id === slideId);
    if (index !== -1) {
        slideShowItems[index] = { ...slideShowItems[index], ...caption };
    }
    updateSlideData();
}


function updateSlideData() {
    var slideData = document.getElementById("slideshowData"); // Assuming 'data' is the ID of the hidden field
    slideData.value = JSON.stringify(slideShowItems); // Convert the object to a JSON string and set it as the value of the hidden field
    console.log("updated SLIDES" + slideData);
}

function changeSlideImage(slideId, image) {
    var slide = slideShowItems[slideId];
    slide.display = "image";
    slide.image = image.image;
    slide.upload = null;
    var thumbElement = document.getElementById("thumb_" + slideId);
    const imgElement = thumbElement.querySelector("img");
    console.log(image);
    if (imgElement) {
        imgElement.src = imagesAsset + image.image;
    }
    const fileElement = document.getElementById("file_input_" + slideId);
    fileElement.value = "";
    updateSlideData();
}

function createNewSlide(slide) {
    if (slide === null) {
        var newSlide = {
            id: slideCount,
            display: "image",
            image: "defaultBanner.jpg",
            upload: null,
            caption: "Enter Caption Here",
        };
        slideShowItems.push(newSlide);
        slideCount++;
        showSlideshowPreview();
    } else {
        var newSlide = {
            id: slideCount,
            display: "image",
            image: slide.image,
            upload: null,
            caption: slide.caption,
        };
        slideShowItems.push(newSlide);
        slideCount++;
    }
}

function showSlideshowPreview() {
    var listFinished = false;
    for (let i = 0; i < 6; i++) {
        const previewId = "preview_" + i;
        const previewElement = document.getElementById(previewId);
        const detail_id = "slide_detail_" + i;
        const detailElement = document.getElementById(detail_id);
        const fileId = "file_input_" + i;
        const fileElement = document.getElementById(fileId);
        const selectID = "image_select_" + i;
        const selectElement = document.getElementById(selectID);
        const thumbId = "thumb_" + i;
        const thumbElement = document.getElementById(thumbId);
        const captionId = "caption_" + i;
        const captionElement = document.getElementById(captionId);

        const addId = "add_" + i;
        const addElement = document.getElementById(addId);
        if (listFinished) {
            previewElement.style.visibility = "hidden";
        } else {
            previewElement.style.visibility = "visible";
            var slide = slideShowItems[i];
            if (slide) {
                fileElement && (fileElement.style.display = "block");
                selectElement && (selectElement.style.display = "block");
                thumbElement && (thumbElement.style.display = "block");
                captionElement && (captionElement.style.display = "block");
                const imgElement = thumbElement.querySelector("img");
                if (imgElement) {
                    if (slide.display === "image") {
                        imgElement.src = imagesAsset + slide.image;
                    } else {
                        if (slide.display == "upload") {
                            const reader = new FileReader();
                            reader.onload = function (event) {
                                imgElement.src = event.target.result;
                            };
                            reader.readAsDataURL(slide.upload);
                        }
                    }
                }
                if (captionElement) {
                    captionElement.value = slide.caption;
                }
                addElement && (addElement.style.display = "none");
            } else {
                fileElement && (fileElement.style.display = "none");
                selectElement && (selectElement.style.display = "none");
                thumbElement && (thumbElement.style.display = "none");
                captionElement && (captionElement.style.display = "none");
                addElement && (addElement.style.display = "block");
                listFinished = true;
            }
        }
    }
}
