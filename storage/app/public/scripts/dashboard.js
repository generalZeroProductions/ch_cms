function returnToDashboard() {
    window.location.href = "/dashboard";
}

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

function toggleEditMode(toggle) {
    console.log(toggle);
    var path = scriptAsset + "set_edit_mode.php";
    var xhr = new XMLHttpRequest();
    xhr.open("POST", path, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    var postData = "editToggle=" + toggle;
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                if(toggle === true)
                {
                window.location.href = "/";
                }
                else{
                    location.reload();
                }
            } else {
                console.error("Error:", xhr.status);
            }
        }
    };
    xhr.send(postData);
}


function viewSite()
{
    window.location.href = "/";
}