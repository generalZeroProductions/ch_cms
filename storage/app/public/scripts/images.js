
function setImageColumsSize() {
    console.log('Setting image sizes');
    // Set width for image-column divs
    const imageColumns = document.querySelectorAll(".image-column");
    imageColumns.forEach((div) => {
        div.style.width = "30%";
         var width = div.offsetWidth; // Access offsetWidth for each div
         console.log("Width of the div: " + width + "px");
    });
    // Set width for image-article divs
    const imageArticles = document.querySelectorAll(".image-article");
    imageArticles.forEach((div) => {
        div.style.width = "70%";
    });
}



function insertUploadFileBar(id) {
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

// function insertUploadFileBar2(iconBar) {

//     if (iconBar) {
//         fetch("/insert_upload_file")
//             .then((response) => response.text()) // Parse response as text
//             .then((html) => {
//                 iconBar.innerHTML = html;
//                 var anchors = iconBar.querySelectorAll("a");
//                 anchors.forEach((anchor) => {
//                     if (anchor.id === "close") {
//                         anchor.onclick = function () {
//                             displayEditIcons(id);
//                         };
//                     }
//                 });
//                 var inputs = iconBar.querySelectorAll("input");
//                 inputs.forEach((input) => {
//                     if (input.id === "upload") {
//                         input.addEventListener("change", (event) => {
//                             displayUploadedImage(id, input);
//                         });
//                     }
//                 });
//             })
//             .catch((error) => console.error("Error loading page:", error));
//     }
// }

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

function displaySelectedFile(id, imageName) {
    if (imageName != "选择一个文件...")
    {
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
function displayUploadedImage(id, input) {
    const imgElement = getImageElementFromCard(id);
    const file = input.files[0];
    const reader = new FileReader();
    reader.onload = function (event) {
        imgElement.src = event.target.result;
    };
    reader.readAsDataURL(file);
    var slide = slideShowItems[id];
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

function getIconBarS(id) {
    var cards = document.querySelectorAll("#edit_icons");
    console.log("how many catrds " + cards.length)
    return cards[0];
}

// function insertFileSelect2(iconBar) {
//     if (iconBar) {
//         fetch("/insert_file_select")
//             .then((response) => response.text()) // Parse response as text
//             .then((html) => {
//                 iconBar.innerHTML = html;
//                 var anchors = iconBar.querySelectorAll("a");
//                 anchors.forEach((anchor) => {
//                     if (anchor.id === "close") {
//                         anchor.onclick = function () {
//                             displayEditIcons(id);
//                         };
//                     }
//                 });
//                 var selects = iconBar.querySelectorAll("select");
//                 selects.forEach((select) => {
//                     if (select.id === "select") {
//                         select.addEventListener("input", (event) => {
//                             displaySelectedFile(id, select.value);
//                         });
//                     }
//                 });
//             })
//             .catch((error) => console.error("Error loading page:", error));
//     }
// }

function insertFileSelect(id) {
    var iconBar = getIconBar(id);
    if (iconBar) {
        fetch("/insert_file_select")
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
                var selects = iconBar.querySelectorAll("select");
                selects.forEach((select) => {
                    if (select.id === "select") {
                        select.addEventListener("input", (event) => {
                            displaySelectedFile(id, select.value);
                        });
                    }
                });
            })
            .catch((error) => console.error("Error loading page:", error));
    }
}
// function displayEditIcons2(id) {
//     var iconBar = getIconBarS(id);
//     if (iconBar) {
//         fetch("/insert_image_icons_2")
//             .then((response) => response.text()) // Parse response as text
//             .then((html) => {
//                 iconBar.innerHTML = html;
//                 var anchors = iconBar.querySelectorAll("a");
//                 anchors.forEach((anchor) => {
//                     if (anchor.id === "file") {
//                         anchor.onclick = function () {
//                             insertFileSelect2(iconBar);
//                         };
//                     }
//                     if (anchor.id === "upload") {
//                         anchor.onclick = function () {
//                             insertUploadFileBar2(iconBar);
//                         };
//                     }
//                 });
//             })
//             .catch((error) => console.error("Error loading page:", error));
//     }
// }

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
                            insertUploadFileBar(id);
                        };
                    }
                });
            })
            .catch((error) => console.error("Error loading page:", error));
    }
}
