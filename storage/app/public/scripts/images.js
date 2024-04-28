function insertUploadFile(id) {
    var iconBar = getIconBar(id);
    if (iconBar) {
        fetch("/insert_upload_file")
            .then((response) => response.text()) // Parse response as text
            .then((html) => {
                iconBar.innerHTML = html;
                var anchors = iconBar.querySelectorAll("a");
                anchors.forEach((anchor) => {
                    if (anchor.id === "close") {
                        anchor.onclick = function () {
                            displayEditIcons(id);
                        };
                    }
                });
                var inputs = iconBar.querySelectorAll("input");
                inputs.forEach((input) => {
                    if (input.id === "upload") {
                        input.addEventListener("change", (event) => {
                            displayUploadedImage(id, input);
                        });
                    }
                });
            })
            .catch((error) => console.error("Error loading page:", error));
    }
}

function displayUploadedImage(slideId, input) {
    const card = document.getElementById("card" + slideId);
    const cardDivs = card.querySelectorAll("div");
    let thumbDiv;
    cardDivs.forEach((div) => {
        if (div.id === "thumb") {
            thumbDiv = div;
        }
    });
    var imgElement = thumbDiv.querySelector("img");
    const file = input.files[0];
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

function getIconBar(id) {
    var card = document.getElementById("card" + id);
    var divs = card.querySelectorAll("div");
    for (let i = 0; i < divs.length; i++) {
        const d = divs[i];
        if (d.id === "edit_icons") {
            return d;
        }
    }
}

function insertFileSelect(id) {
    var iconBar = getIconBar(id);
    if (iconBar) {
        fetch("/insert_file_select")
            .then((response) => response.text()) // Parse response as text
            .then((html) => {
                iconBar.innerHTML = html;
                var anchors = card.querySelectorAll("a");
                anchors.forEach((anchor) => {
                    if (anchor.id === "close") {
                        anchor.onclick = function () {
                            displayEditIcons(id);
                        };
                    }
                });
            })
            .catch((error) => console.error("Error loading page:", error));
    }
}

function displayEditIcons(id) {
    var iconBar = getIconBar(id);
    if (iconBar) {
        fetch("/insert_image_icons_3")
            .then((response) => response.text()) // Parse response as text
            .then((html) => {
                iconBar.innerHTML = html;
                var card = document.getElementById("card" + id);
                var anchors = card.querySelectorAll("a");
                anchors.forEach((anchor) => {
                    if (anchor.id === "trash") {
                        anchor.onclick = function () {
                            deleteSlide(id);
                        };
                    }
                    if (anchor.id === "file") {
                        anchor.onclick = function () {
                            insertFileSelect(id);
                        };
                    }
                    if (anchor.id === "upload") {
                        anchor.onclick = function () {
                            insertUploadFile(id);
                        };
                    }
                });
            })
            .catch((error) => console.error("Error loading page:", error));
    }
}
