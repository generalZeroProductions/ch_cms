var slideShowItems = [];
var previewList;
var scrollAt = 0;
var slideDiv;

function editSlidesForm(modBody, location, slideList) {
    console.log("EDIT BY MODAL");
    scrollAt = window.scrollY;
    slideShowItems = [];
    slideDiv = modBody;

    const parseSlides = JSON.parse(slideList);
    const locItem = JSON.parse(location);
    parseSlides.forEach((slide) => {
        createNewSlide(slide);
    });

    fetch("/slideshow_edit")
        .then((response) => response.text())
        .then((html) => {
            modBody.innerHTML = html;
            if (slideDiv)
                document.getElementById("row_id").value = locItem.row.id;
            document.getElementById("page_id").value = locItem.page.id;
            document.getElementById("scroll_to").value = window.scrollY;

            var runScriptsDiv = document.getElementById("run_scripts");
            if (runScriptsDiv) {
                var innerHtml = runScriptsDiv.innerHTML;
                var toolTipCall = innerHtml.match(/toolTipStart\([^)]*\)/);
                if (toolTipCall !== null) {
                    eval(toolTipCall[0]);
                }
            }
            showAllSlides();
        })
        .catch((error) => {
            console.error("Error loading slideshowEdit:", error);
        });
}

function showAllSlides() {
    var listFinished = false;
    var cards = slideDiv.querySelectorAll(".card");
    for (let i = 0; i < 6; i++) {
        (function (index) {
            var slide = slideShowItems[index];
            cards.forEach((card) => {
                if (card.id === "card" + index) {
                    if (listFinished) {
                        const card = document.getElementById("card" + index);
                        card.innerHTML = "";
                    } else {
                        if (slide) {
                            insertSlidePreview(index);
                        } else {
                            insertAddSlideCard(index);
                            listFinished = true;
                        }
                    }
                }
            });
        })(i);
    }
}

function insertSlidePreview(id) {
    const card = document.getElementById("card" + id);
    fetch("/insert_slide_card")
        .then((response) => response.text())
        .then((html) => {
            card.innerHTML = html;
            displayEditIcons(id);
        })
        .catch((error) => {
            console.error("Error loading slideshowEdit:", error);
        });
    console.log(" Preview set " + id);
}

function insertAddSlideCard(id) {
    const card = document.getElementById("card" + id);
    fetch("/insert_add_image_card")
        .then((response) => response.text())
        .then((html) => {
            card.innerHTML = html;
            displayEditIcons(id);
        })
        .catch((error) => {
            console.error("Error loading slideshowEdit:", error);
        });
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
    var card = document.getElementById("card" + slideId);
    const imgElement = card.querySelector("img");
    if (imgElement) {
        imgElement.src = imagesAsset + image;
    }
    // const fileElement = document.getElementById("file_capture_" + slideId);
    // fileElement.value = "";
    updateSlideData();
}

function deleteSlide(slide) {
    slideShowItems.splice(slide, 1);
    for (let i = slide; i < slideShowItems.length; i++) {
        slideShowItems[i].index--;
    }
    updateSlideData();
    showSlideshowPreview();
    setTimeout(resetScroll, 1);
}

function createNewSlide(slide) {
    if (slide === null) {
        var newSlide = {
            id: slideShowItems.length,
            source: "server",
            image: "defaultBanner.jpg",
            file: null,
            caption: "Enter Caption Here",
            record: null,
        };
        slideShowItems.push(newSlide);
        updateSlideData();
        showSlideshowPreview();
        setTimeout(resetScroll, 1);
    } else {
        var newSlide = {
            id: slideShowItems.length,
            source: "server",
            image: slide.image,
            file: null,
            caption: slide.caption,
            record: slide.record,
        };
        slideShowItems.push(newSlide);
    }
}
