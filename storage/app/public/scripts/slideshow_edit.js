var slideShowItems = [];
var deletedSlides = [];

function slideHeightListen(rowId, height) {
    var row = document.getElementById("rowInsert" + rowId);
    var forms = row.querySelectorAll("#change_slide_height");
    addFieldAndValue("slide_row_tag" + rowId, rowId);
    forms[0].addEventListener("submit", function (event) {
        preventDefault();
    });
    var btn = document.getElementById('submit_slide_height_btn');
    btn.addEventListener("click", function (event) {
        updateSlideHeight(slideHeight, rowId);
        btn.classList.add("disabled");
        btn.setAttribute("disabled",'true');
    });
    var slideHeight = document.getElementById("slide_height" + rowId);
    slideHeight.value = height;
    slideHeight.addEventListener("input", function (event) {
        warnUnusable(slideHeight, rowId);
        btn.classList.remove("disabled");
        btn.removeAttribute("disabled");
    });
    slideHeight.addEventListener("focus", function (event) {
        function handleKeyDown(event) {
            if (event.key === "Enter") {
                updateSlideHeight(slideHeight, rowId);
                btn.classList.add("disabled");
                btn.setAttribute("disabled",'true');
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
    deletedSlides = [];
    console.log(jItem);
    var item = JSON.parse(jItem);
    item.slides.forEach((slide) => {
        createNewSlide(slide);
    });
    fetch("/slideshow_edit")
        .then((response) => response.text())
        .then((html) => {
            modBody.innerHTML = html;
            modTitleLabel.innerHTML = "幻灯片编辑器";
            document.getElementById("row_id");

            document.getElementById("row_id").value = item.rowId;
            document.getElementById("page_id").value = item.pageId;
            document.getElementById("scroll_to").value = window.scrollY;
            var closeBtn = document.getElementById("close_main_modal");
            closeBtn.addEventListener("click", function (event) {
                console.log("clicked close");
                enableScrolling();
            });
            var submitButton = document.getElementById("submit_slideshow_btn");
            submitButton.addEventListener("click", function (event) {
                if (submitButton.disabled) {
                    event.preventDefault();
                }
            });
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

function warnUnusable(input, rowId) {
    input.style.backgroundColor = "";
    var height = input.value;
    var cantUse = document.getElementById("cant_use" + rowId);

    if (height < 50) {
        cantUse.innerHTML = "该值必须大于 50 像素。";
        input.style.backgroundColor = "yellow";
        return;
    }
    if (height > 500) {
        cantUse.innerHTML = "该值必须小于 500 像素。";
        input.style.backgroundColor = "yellow";
        return;
    }
    cantUse.innerHTML = "";
    input.style.backgroundColor = "";
}

function updateSlideHeight(slideHeight, rowId) {
    var rowDiv = document.getElementById("rowInsert" + rowId);
    var banners = rowDiv.querySelectorAll(".banner_container");
    var height = slideHeight.value;
    slideHeight.style.backgroundColor = "";
    var cantUse = document.getElementById("cant_use" + rowId);
    var usable = true;
    if (height < 50) {
        var cantUse = document.getElementById("cant_use" + rowId);
        cantUse.innerHTML = "该值必须大于 50 像素。";
        slideHeight.style.backgroundColor = "yellow";
        usable = false;
    }
    if (height > 500) {
        cantUse.innerHTML = "该值必须小于 500 像素。";
        slideHeight.style.backgroundColor = "yellow";
        usable = false;
    }

    if (usable) {
        banners.forEach((banner) => {
            banner.style.height = height + "px";
            addFieldAndValue("send_height" + rowId, height);
            writeNoReturn("change_slide_height");
        });
    }
}

function showAllSlides() {
    var listFinished = false;
    var cards = modBody.querySelectorAll(".card");

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
    var slide = slideShowItems[id];
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
    var slide = slideShowItems[id];
    slide.caption = caption;
    updateSlideData();
}

function updateSlideData() {
    var slideData = document.getElementById("slide_show_data");
    updateData = JSON.stringify(slideShowItems); // Assuming 'data' is the ID of the hidden field
    slideData.value = updateData; // Convert the object to a JSON string and set it as the value of the hidden field
    var btn = document.getElementById("submit_slideshow_btn");
    var warn = document.getElementById("cant_sumbit_slides");
    console.log("total slides " + slideShowItems.length);
    if (slideShowItems.length === 0) {
        btn.classList.add("disabled");
        btn.setAttribute("style", "cursor:default");
        btn.removeAttribute("onclick");
        btn.disabled = true;

        warn.innerHTML = "无法提交空幻灯片";
    } else {
        btn.classList.remove("disabled");
        btn.disabled = false;
        btn.setAttribute("style", "cursor:pointer");
        warn.innerHTML = "";
    }
}

function deleteSlide(slide) {
    var delete_slide = slideShowItems[slide];
    deletedSlides.push(delete_slide);
    updateData = JSON.stringify(deletedSlides);
    var deletedSlidesField = document.getElementById("deleted_slides");
    deletedSlidesField.value = updateData;
    slideShowItems.splice(slide, 1);
    for (let i = slide; i < slideShowItems.length; i++) {
        if (slideShowItems[i].index > slide) {
            slideShowItems[i].index--;
        }
    }

    updateSlideData();

    showAllSlides();
}

function createNewSlide(slide) {
    if (slide === null) {
        console.log("TRING to create");
        var newSlide = {
            source: "server",
            image: "defaultSlide.jpg",
            file: null,
            caption: "Enter Caption Here",
            record: null,
            index: slideShowItems.length,
        };
        slideShowItems.push(newSlide);
        updateSlideData();
        showAllSlides();
    } else {
        var newSlide = {
            source: "server",
            image: slide.image,
            file: null,
            caption: slide.caption,
            record: slide.record,
            index: slide.index,
        };
        slideShowItems.push(newSlide);
    }
    console.log(slideShowItems);
}
