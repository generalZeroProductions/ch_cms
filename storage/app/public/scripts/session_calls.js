

function setEditMode(toggle) {
    window.location.href = "/session/edit?"+toggle+"?"+"editon";
}


function leavePageEdit(route) {
    var path = scriptAsset + "set_edit_mode.php";
    var xhr = new XMLHttpRequest();
    xhr.open("POST", path, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    var postData = "editToggle=" + true;
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                if(route)
                {
                window.location.href = "/"+route;
                }
                else{
                    window.location.href = "/dashboard";
                }
            } else {
                console.error("Error:", xhr.status);
            }
        }
    };
    xhr.send(postData);
}