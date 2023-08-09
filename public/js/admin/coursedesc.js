// Click Show Hide Course List
var deg = 0;
var courseItems = document.querySelectorAll(".course-content-item-title");
courseItems.forEach((item) => {
    item.addEventListener("click", function () {
        item.nextElementSibling.classList.toggle("course-content-hide");
        item.nextElementSibling.classList.toggle("course-content-show");
        if (item.firstElementChild.classList.contains("rotate")) {
            item.firstElementChild.style.animation = "unset";
            item.firstElementChild.style.animation =
                "rotate-left 0.1s ease-in-out both";
        } else {
            item.firstElementChild.style.animation = "unset";
            item.firstElementChild.style.animation =
                "rotate-right 0.1s ease-in-out both";
        }
        if (deg == 0) deg = 180;
        if (deg == 180) deg = 0;
        item.firstElementChild.classList.toggle("rotate");
    });
});
