function changePageTitle(location, divId) {
    const locItem = JSON.parse(location);
    var titleDiv = document.getElementById(divId);
    fetch("/title_change")
        .then((response) => response.text())
        .then((html) => {
            titleDiv.innerHTML = html;
            document.getElementById("page_title").value = locItem.page.title;
            document.getElementById("page_id").value = locItem.page.id;
            document.getElementById("scroll_to").value = window.scrollY;
        })
        .catch((error) => console.error("Error loading newNavSelect:", error));
}