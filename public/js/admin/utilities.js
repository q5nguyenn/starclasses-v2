// Validate field
function checkEmpty(element, alert, position) {
    if (!element.val() || element.val().length == 0) {
        if (position == "n") {
            element.nextAll(".input-item-error:first").html(alert);
        } else {
            element.parent().next(".input-item-error").html(alert);
        }
        return false;
    } else {
        if (position == "n") {
            element.nextAll(".input-item-error:first").html("&nbsp;");
        } else {
            element.parent().next(".input-item-error").html("&nbsp;");
        }
        return true;
    }
}

//Preview upload image
function previewUploadImage(input, avatar) {
    input.change(function () {
        const file = this.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function (event) {
                avatar.attr("src", event.target.result);
            };
            reader.readAsDataURL(file);
        }
    });
}

//Reload page
function reloadPage() {
    // Lưu trữ giá trị cuộn khi reload trang
    window.addEventListener("beforeunload", function () {
        localStorage.setItem("scrollPosition", window.scrollY);
    });

    // Khôi phục giá trị cuộn sau khi trang đã tải lại
    window.addEventListener("load", function () {
        var scrollPosition = localStorage.getItem("scrollPosition");
        if (scrollPosition !== null) {
            window.scrollTo(0, scrollPosition);
            localStorage.removeItem("scrollPosition");
        }
    });
}
