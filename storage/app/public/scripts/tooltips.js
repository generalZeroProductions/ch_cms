var tooltipTimeout;

function showTooltip(tooltipId) {
    var tooltip = document.getElementById(tooltipId);
    if (tooltip) {
        tooltip.style.display = "block";
        clearTimeout(tooltipTimeout);
    }
}

function hideTooltip(tooltipId) {
    tooltipTimeout = setTimeout(function () {
        var tooltip = document.getElementById(tooltipId);
        if (tooltip) {
            tooltip.style.display = "none";
        }
    }, 10);
}

function toolTipStart() {
    for (let i = 0; i < 6; i++) {
        var element = document.getElementById("trash_icon_" + i);
        element.addEventListener("mouseover", function () {
            showTooltip("tooltip_trash" + i);
        });
        element.addEventListener("mouseout", function () {
            hideTooltip("tooltip_trash" + i);
        });
        var element = document.getElementById("file_icon_" + i);
        element.addEventListener("mouseover", function () {
            showTooltip("tooltip_file" + i);
        });
        element.addEventListener("mouseout", function () {
            hideTooltip("tooltip_file" + i);
        });
        var element = document.getElementById("upload_icon_" + i);
        element.addEventListener("mouseover", function () {
            showTooltip("tooltip_upload" + i);
        });
        element.addEventListener("mouseout", function () {
            hideTooltip("tooltip_upload" + i);
        });
    }
}