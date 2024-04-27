function showUploadImageStandard(modContent, item, location) {
    var itemItem = JSON.parse(item);
    var locItem = JSON.parse(location);
    document.getElementById("base-modal-title").innerHTML = "选择图像";
    fetch("/select_image_upload")
        .then((response) => response.text())
        .then((html) => {
            modContent.innerHTML = html;
            document.getElementById("page_id").value = locItem.page.id;
            document.getElementById("column_id").value = itemItem.id;
            document.getElementById("page_id_at_select").value =
                locItem.page.id;
            document.getElementById("column_id_select").value = itemItem.id;
            document.getElementById("scroll_to").value = window.scrollY;
            document.getElementById("scroll_to_select").value = window.scrollY;
            
        })
        .catch((error) =>
            console.error("Error loading image select form:", error)
        );
}