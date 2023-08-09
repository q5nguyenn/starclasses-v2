export {
    checkEmpty,
    previewUploadImage,
    debounce,
    getTemplStar,
    dateFormatVN,
    reloadPage,
};

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
// Debounce
function debounce(func, wait, immediate) {
    var timeout;
    return function executedFunction() {
        var context = this;
        var args = arguments;
        var later = function () {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };
        var callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
    };
}

function getTemplStar(rate) {
    rate = Math.round(rate * 2) / 2;
    let rateInteger = Math.floor(rate);
    let rateFloat = rate - rateInteger;
    let htmlRate = "";
    for (let i = 1; i <= rateInteger; i++) {
        htmlRate += '<i class="bi bi-star-fill"></i>';
    }
    if (rateFloat == 0.5) {
        htmlRate += '<i class="bi bi-star-half"></i>';
        for (i = rateInteger + 2; i <= 5; i++) {
            htmlRate += '<i class="bi bi-star"></i>';
        }
    } else {
        for (i = rateInteger + 1; i <= 5; i++) {
            htmlRate += '<i class="bi bi-star"></i>';
        }
    }
    return htmlRate;
}

// Chuyển đổi sang định dạng "DD/MM/YYYY"
function dateFormatVN(dateString) {
    let dateObject = new Date(dateString);
    let day = dateObject.getDate();
    let month = dateObject.getMonth() + 1;
    let year = dateObject.getFullYear();
    let formattedDate =
        (day < 10 ? "0" : "") +
        day +
        "/" +
        (month < 10 ? "0" : "") +
        month +
        "/" +
        year;
    return formattedDate;
}

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
