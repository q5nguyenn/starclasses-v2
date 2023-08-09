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

// Show hide Video
var videoLinks = document.querySelectorAll(".count-content-video");
var video = document.querySelector(".video");
var videoBlur = document.querySelector(".video-blur");
var popupNewStudent = document.querySelector(".new-student");
var navs = document.querySelector(".navs");

// Show
// videoLinks.forEach((item) => {
//     item.addEventListener("click", function () {
//         video.style.animation =
//             "slide-in-top-video .5s cubic-bezier(.25,.46,.45,.94) both";
//         videoBlur.style.animation =
//             "fade-in .5s cubic-bezier(.39,.575,.565,1.000) both";
//         videoBlur.style.display = "block";
//         popupNewStudent.style.display = "none";
//         navs.style.display = "none";
//     });
// });

// Hide
// videoBlur.addEventListener("click", function () {
//     video.style.animation =
//         "slide-out-top-video .5s cubic-bezier(.25,.46,.45,.94) both";
//     videoBlur.style.animation = "fade-out .5s ease-out both";
//     setTimeout(() => {
//         videoBlur.style.display = "none";
//         popupNewStudent.style.display = "flex";
//         navs.style.display = "flex";
//     }, 300);
// });

// Show Popup Position
var courseCover = document.querySelector(".course-cover");
var popupCourse = document.querySelector(".course-popup-container");
var popupCourseOffsetLeft =
    courseCover.offsetLeft +
    courseCover.clientWidth +
    (5 * (courseCover.clientWidth / 65) * 100) / 100;

var header = document.querySelector(".navs");
var heightNav = header.offsetHeight;
var footer = document.querySelector("footer");

window.addEventListener("scroll", function (e) {
    if (window.pageYOffset >= heightNav) {
        if (window.innerWidth < 767) {
            popupCourse.style.bottom = "0";
            popupCourse.style.top = "unset";
        } else {
            popupCourse.style.bottom = "unset";
            popupCourse.style.top = "50px";
        }
    } else {
        if (window.innerWidth < 767) {
            popupCourse.style.bottom = "0";
            popupCourse.style.top = "unset";
        } else {
            popupCourse.style.bottom = "unset";
            popupCourse.style.top = "70px";
        }
    }
});
if (window.innerWidth > 767) {
    popupCourse.style.left = popupCourseOffsetLeft + "px";
    popupCourse.style.width =
        (30 * (courseCover.clientWidth / 65) * 100) / 100 + "px";
    window.addEventListener("scroll", function (e) {
        var popUpoffSetBottom =
            window.pageYOffset + window.innerHeight - footer.offsetTop;
        if (popUpoffSetBottom > 0) {
            popupCourse.style.top = "unset";
            popupCourse.style.bottom = popUpoffSetBottom + 20 + "px";
        }
    });
}
if (window.innerWidth < 767) {
    popupCourse.style.left = 0;
    popupCourse.style.width = "100%";
    popupCourse.style.bottom = 0;
    popupCourse.style.top = "unset";
}

// Hiển thị thông tin dựa vào Value
// Get SearchValue
function getIdCourse() {
    var url = new URL(document.URL);
    var value = url.searchParams.get("id");
    return value;
}

// Write A comment

// Like hoặc Dislike và Report
var commentsWrapper = document.querySelector(".course-comment-wrapper");
commentsWrapper.addEventListener("click", function (e) {
    if (e.target.matches(".bi-hand-thumbs-up")) {
        e.target.className = "bi bi-hand-thumbs-up-fill";
        if (
            e.target.nextElementSibling.classList.contains(
                "bi-hand-thumbs-down-fill"
            )
        ) {
            e.target.nextElementSibling.className = "bi bi-hand-thumbs-down";
        }
    } else if (e.target.matches(".bi-hand-thumbs-down")) {
        e.target.className = "bi bi-hand-thumbs-down-fill";
        if (
            e.target.previousElementSibling.classList.contains(
                "bi-hand-thumbs-up-fill"
            )
        ) {
            e.target.previousElementSibling.className = "bi bi-hand-thumbs-up";
        }
    } else if (e.target.matches(".bi-hand-thumbs-down-fill")) {
        e.target.className = "bi bi-hand-thumbs-down";
    } else if (e.target.matches(".bi-hand-thumbs-up-fill")) {
        e.target.className = "bi bi-hand-thumbs-up";
    }
    if (e.target.matches(".course-comment-report")) {
        var reportShow = document.querySelector(".show");
        if (reportShow) {
            reportShow.classList.remove("show");
        } else {
            e.target.firstElementChild.classList.toggle("show");
        }
    }
});

// Không đăng nhập thì ẩn cái gì
var courseCommentUser = document.querySelector(".course-comment-user");
var login = getItem("login");
if (login == true) {
    courseCommentUser.style.display = "block";
}

function getValueId() {
    var url = new URL(document.URL);
    var value = url.searchParams.get("id");
    return value;
}

// Hiển thị nhiều ít - View more
var viewMoreDesc = document.querySelector(".course-content-info-showmore");
viewMoreDesc.addEventListener("click", function () {
    viewMoreDesc.parentElement.classList.toggle("show-view-more");
    if (this.firstElementChild.classList.contains("rotate")) {
        this.firstElementChild.style.animation = "unset";
        this.firstElementChild.style.animation =
            "rotate-left 0.1s ease-in-out both";
        this.lastElementChild.textContent = "Show more";
    } else {
        this.firstElementChild.style.animation = "unset";
        this.firstElementChild.style.animation =
            "rotate-right 0.1s ease-in-out both";
        this.lastElementChild.textContent = "Show less";
    }
    this.firstElementChild.classList.toggle("rotate");
});

// Share
var fbButton = document.getElementById("fb-share-button");
fbButton.addEventListener("click", function () {
    var url = window.location.href;
    window.open(
        "https://www.facebook.com/sharer/sharer.php?u=" + url,
        "facebook-share-dialog",
        "width=800,height=600"
    );
    return false;
});

// Fake loadig view more
function loadViewMore() {
    viewMore.innerHTML = `<div class="loading-chat">
                              <div>
                              <span></span>
                              <span></span>
                              <span></span>
                              </div>
                            </div>`;
    setTimeout(() => {
        viewMore.innerHTML = "Show more";
    }, 500);
}

// Print This Course
var printThisCourse = document.querySelector(".course-print");
printThisCourse.addEventListener("click", handlePrintCoure);

function handlePrintCoure() {
    // var divContents = document.body.innerHTML;
    var divContentTop = document.querySelector(".course-wrapper").innerHTML;
    var divContentBody = document.querySelector(".course-intro").innerHTML;
    var divContentBot1 = document.querySelector(".course-content").innerHTML;
    var divContentBot2 = document.querySelector(
        ".course-content-info-print"
    ).innerHTML;
    var a = window.open("", "", "height=500, width=500");
    a.document.write("<html>");
    a.document.write(
        `<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Star Classes - Print Course</title>
    <link rel="icon" type="image/x-icon" href="./images/x-icon.ico" />
    <link rel="stylesheet" href="./css/style.css" />
    <link rel="stylesheet" href="./css/coursedesc.css" />
    <link rel="stylesheet" href="./css/print.css" />
  </head>`
    );
    a.document.write(
        `<main>
      <div class="course-wrapper">`
    );
    a.document.write(`<div class="print-company">
                      <a href="./index.html" class="logo logo-animation">
                        <div class="logo-inner">
                          <img src="./images/logo.png" alt="" />
                        </div>
                      </a>
                      <div>
                        <div>Company:</div>
                        <div>Address:</div>
                        <div>Tel:</div>
                        <div>Fax:</div>
                      </div>
                      <div>
                        <div>Star Classes Joint Stock Company</div>
                        <div>No. 8 Ton That Thuyet, My Dinh, Hanoi</div>
                        <div>+84 986295956</div>
                        <div>+84 986295956</div>
                      </div>
                      <div>
                        <div id="bill-date">Date: ${time}</div>
                      </div>
                    </div>`);
    a.document.write(divContentTop);
    a.document.write(divContentBody);
    a.document.write(divContentBot1);
    a.document.write(divContentBot2);
    a.document.write(
        `</div>
    </main>`
    );
    a.document.write("</html>");
    a.document.close(); // necessary for IE >= 10
    a.focus(); // necessary for IE >= 10*/
    // a.print();
    setTimeout(function () {
        a.print();
        // a.close();
    }, 1000);
    return true;
}

var time = new Date().toLocaleString("vi-VI");
