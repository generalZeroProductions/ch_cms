
function paginatePages() {
    const pagesDiv = document.getElementById("pagesDiv");
    if(!pagesDiv)
    {
        console.log("NO PAGE DIV");
    }
    fetch("/display_all_pages")
        .then((response) => response.json()) // Parse response as JSON
        .then((data) => {
            pagesDiv.innerHTML = data.html;
        })
        .catch((error) => console.error("Error loading pages:", error));
}



function viewSite()
{
    window.location.href = "/";
}
function dashboardReturn()
{
    window.location.href = "/session/endbuild";
}
function setEditMode(toggle, route) {
    window.location.href = "/session/edit?"+toggle+"?"+route+"?"+window.scrollY;
}



function enterPageBuild(route)
{
    window.location.href = "/session/build?"+route;
}