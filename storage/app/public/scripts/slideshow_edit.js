var slideShowItems = [];
var previewList;
var scrollAt = 0;
var slideDiv;

function slideHeightListen(rowId, height) {
    var row = document.getElementById("rowInsert" + rowId);
    var forms = row.querySelectorAll("#change_slide_height");
    forms[0].addEventListener("submit", function (event) {
        preventDefault();
    });
    var slideHeight = document.getElementById("slide_height" + rowId);
    slideHeight.value = height;
    slideHeight.addEventListener("focus", function (event) {
        function handleKeyDown(event) {
            if (event.key === "Enter") {
                updateSlideHeight(slideHeight, rowId)
            }
        }
        document.addEventListener("keydown", handleKeyDown);
    });
    slideHeight.addEventListener("blur", function (event) {
        document.removeEventListener("keydown", handleKeyDown);
    });
}

function editSlidesForm(jItem) {
    slideShowItems = [];
    slideDiv = modBody;
    var item = JSON.parse(jItem);
    item.slides.forEach((slide) => {
        createNewSlide(slide);
    });
    console.log("ITEM ROW ID " + item.rowId);
    fetch("/slideshow_edit")
        .then((response) => response.text())
        .then((html) => {
            modBody.innerHTML = html;
            document.getElementById("row_id").value = item.rowId;
            document.getElementById("page_id").value = item.pageId;
            document.getElementById("scroll_to").value = window.scrollY;

            var runScriptsDiv = document.getElementById("run_scripts");
            if (runScriptsDiv) {
                var innerHtml = runScriptsDiv.innerHTML;
                var toolTipCall = innerHtml.match(/toolTipStart\([^)]*\)/);
                if (toolTipCall !== null) {
                    eval(toolTipCall[0]);
                }
            }
            updateSlideData();
            showAllSlides();
        })
        .catch((error) => {
            console.error("Error loading slideshowEdit:", error);
        });
}

function updateSlideHeight(slideHeight, rowId) {
    console.log("change input");
    var rowDiv = document.getElementById("rowInsert" + rowId);
    var banners = rowDiv.querySelectorAll(".banner_container");
    var height = slideHeight.value;
    if (height < 50) {
        height = 50;
    }
    if (height > 500) {
        height = 500;
    }
    banners.forEach((banner) => {
        banner.style.height = height + "px";
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
            setImageFromSlide(id);
            setCaptionFromSlide(id);
        })
        .catch((error) => {
            console.error("Error loading slideshowEdit:", error);
        });
    console.log(" Preview set " + id);
}
function setImageFromSlide(id) {
    const slide = slideShowItems[id];
    const imgElement = getImageElementFromCard(id);
    if (imgElement) {
        imgElement.src = imagesAsset + slide.image;
    }
}
function getImageElementFromCard(id) {
    var thumbDiv = getThumbDiv(id);
    var imgElement = thumbDiv.querySelector("img");
    if (imgElement) {
        return imgElement;
    }
}
function getThumbDiv(id) {
    const card = document.getElementById("card" + id);
    var divs = card.querySelectorAll("div");
    for (let i = 0; i < divs.length; i++) {
        const d = divs[i];
        if (d.id === "thumb") {
            return d;
        }
    }
}

function setCaptionFromSlide(id) {
    const slide = slideShowItems[id];
    var caption = getCaptionInput(id);
    if (caption) {
        caption.value = slide.caption;
    }
    caption.addEventListener("change", (event) => {
        updateSlideCaption(id, caption.value);
    });
}

function getCaptionElementFromCard(id) {
    var imgElement = thumbDiv.querySelector("img");
    if (imgElement) {
        return imgElement;
    }
}

function getCaptionInput(id) {
    const card = document.getElementById("card" + id);
    var inputs = card.querySelectorAll("input");
    for (let i = 0; i < inputs.length; i++) {
        const d = inputs[i];
        if (d.id === "caption") {
            return d;
        }
    }
}

function insertAddSlideCard(id) {
    const card = document.getElementById("card" + id);
    fetch("/insert_add_image_card")
        .then((response) => response.text())
        .then((html) => {
            card.innerHTML = html;
            var anchors = card.querySelectorAll("a");
            anchors.forEach((anchor) => {
                if (anchor.id === "add_slide") {
                    console.log("FOUND ADD ANCHOR");
                    anchor.onclick = function () {
                        createNewSlide(null);
                    };
                }
            });
        })
        .catch((error) => {
            console.error("Error loading slideshowEdit:", error);
        });
}

function updateSlideCaption(id, caption) {
    console.log("caption change");
    var slide = slideShowItems[id];
    slide.caption = caption;
    updateSlideData();
}

function updateSlideData() {
    var slideData = document.getElementById("slide_show_data");
    console.log(slideShowItems);
    updateData = JSON.stringify(slideShowItems); // Assuming 'data' is the ID of the hidden field
    slideData.value = updateData; // Convert the object to a JSON string and set it as the value of the hidden field
}

function deleteSlide(slide) {
    slideShowItems.splice(slide, 1);
    for (let i = slide; i < slideShowItems.length; i++) {
        slideShowItems[i].index--;
    }
    updateSlideData();
    showAllSlides();
    setTimeout(resetScroll, 1);
}

function createNewSlide(slide) {
    if (slide === null) {
        console.log("TRING to create");
        var newSlide = {
            id: slideShowItems.length,
            source: "server",
            image: "defaultSlide.jpg",
            file: null,
            caption: "Enter Caption Here",
            record: null,
        };
        slideShowItems.push(newSlide);
        updateSlideData();
        showAllSlides();
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
