import { getTemplStar, dateFormatVN, debounce } from "./utilities.js";
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

// View more desc
$(".course-content-info-showmore").click(function (e) {
    if ($(this).data("show") == "off") {
        $(".course-content-info-item").css("height", "max-content");
        $(this).data("show", "on");
    } else {
        $(".course-content-info-item").css("height", "200px");
        $(this).data("show", "off");
    }
    let icon = $(this).find(".bi-chevron-up");
    icon.toggleClass("rotate");
    icon.toggleClass("rotate-reset");
});

// Like course
$(".course-heart").click(function (e) {
    let that = $(this);
    if ($(this).hasClass("like")) {
        $(this).removeClass("like");
        let urlRequest = $(this).data("delete");
        $.ajax({
            type: "get",
            url: urlRequest,
            success: function (response) {
                if (response.code == 200) {
                    that.removeClass("like");
                }
            },
        });
    } else {
        let urlRequest = $(this).data("create");
        $(this).addClass("like");
        $.ajax({
            type: "get",
            url: urlRequest,
            success: function (response) {
                if (response.code == 200) {
                    that.addClass("like");
                }
            },
        });
    }
});

$("#course-star-rate i").click(function (e) {
    e.preventDefault();
    let rate = $(this).data("rate");
    $('[name="rate"]').val(rate);
    for (let i = 1; i <= 5; i++) {
        if (i <= rate) {
            $(`[data-rate=${i}]`).addClass("bi-star-fill");
            $(`[data-rate=${i}]`).removeClass("bi-star");
        } else {
            $(`[data-rate=${i}]`).removeClass("bi-star-fill");
            $(`[data-rate=${i}]`).addClass("bi-star");
        }
    }
});

// Thêm vật phẩm vào giỏ hàng
$("#add-course").click(function (e) {
    let that = $(this);
    e.preventDefault();
    let urlRequest = $(this).attr("cart-create");
    if (login) {
        $.ajax({
            type: "get",
            url: urlRequest,
            success: function (response) {
                if (!cartCourse && !buyCourse) {
                    $(".popup-add-cart-sucess").show();
                    setTimeout(() => {
                        that.text("This course is already in your cart");
                        $(".popup-add-cart-sucess").remove();
                        $("#cart-course").show();
                        $("#cart-course").html(
                            parseInt($("#cart-course").html()) + 1
                        );
                    }, 2000);
                }
            },
        });
    } else {
        window.open("/signin", "_self");
    }
});

// Get more course related
// let page_reivews = 0;
// $("#get-more-comment").click(function (e) {
//     page_reivews++;
//     let htmlResult = "";
//     e.preventDefault();
//     let that = $(this);
//     let urlRequest = $(this).data("url");
//     let data = {
//         page: page_reivews,
//         course_id: course_id,
//     };
//     $.ajax({
//         type: "GET",
//         url: urlRequest,
//         data: data,
//         success: function (response) {
//             response["data"].forEach((item) => {
//                 // let rate = parseInt(item['rate']);
//                 let tempStar = getTemplStar(item["rate"]);
//                 let dateFormat = dateFormatVN(item["created_at"].split("T")[0]);
//                 htmlResult += `<div class="course-comment-item">
// 											<div class="course-comment-item-top">
// 												<div class="course-comment-avatar">
// 													<img src="${BASE_URL}${item["thumbnail"]}" alt="">
// 												</div>
// 												<div class="course-comment-rate">
// 													<div class="course-comment-name">${item["user_name"]}</div>
// 													<div class="course-commnet-rate-star">
// 														<span class="course-star">
// 															${tempStar}
// 														</span>
// 														<span>${dateFormat}</span>
// 													</div>
// 												</div>
// 												<div class="course-comment-report">
// 													<a class="course-comment-report-popup" data-url="${urlReport}?id=${item["id"]}">
// 													Report
// 													</a>
// 													<i class="bi bi-three-dots-vertical"></i>
// 												</div>
// 											</div>
// 											<div class="course-comment-content">${item["content"]}</div>
// 											<div class="course-commnet-like">
// 												<span>Helpful?</span>
// 												<span>
// 													<i class="bi bi-hand-thumbs-up"> </i>
// 													<i class="bi bi-hand-thumbs-down"></i>
// 												</span>
// 											</div>
// 										</div>	`;
//             });
//             $(".course-comment-wrapper").html(htmlResult);
//             if (response["status"] == -1) {
//                 that.html("That's all");
//             }
//         },
//     });
// });

// Get more reviews
let page_courses_related = 0;
$("#get-more-comment").click(function (e) {
    page_courses_related++;
    let htmlResult = "";
    e.preventDefault();
    let that = $(this);
    let urlRequest = $(this).data("url");
    console.log(urlRequest);
    let data = {
        page: page_courses_related,
        course_id: course_id,
    };
    $.ajax({
        type: "GET",
        url: urlRequest,
        data: data,
        success: function (response) {
            if (response["status"] == -1) {
                that.html("That's all");
                return;
            }
            that.html(`<div class="loading-chat">
					<div>
					<span></span>
					<span></span>
					<span></span>
					</div>
					</div>`);
            setTimeout(() => {
                response["data"].forEach((item) => {
                    let tempStar = getTemplStar(item["rate"]);
                    let dateFormat = dateFormatVN(
                        item["created_at"].split("T")[0]
                    );
                    htmlResult += `<div class="course-comment-item">
										<div class="course-comment-item-top">
											<div class="course-comment-avatar">
												<img src="${BASE_URL}${item["thumbnail"]}" alt="">
											</div>
											<div class="course-comment-rate">
												<div class="course-comment-name">${item["user_name"]}</div>
												<div class="course-commnet-rate-star">
													<span class="course-star">
														${tempStar}
													</span>
													<span>${dateFormat}</span>
												</div>
											</div>
											<div class="course-comment-report">
												<a class="course-comment-report-popup" data-url="${urlReport}?id=${item["id"]}">
												Report
												</a>
												<i class="bi bi-three-dots-vertical"></i>
											</div>
										</div>
										<div class="course-comment-content">${item["content"]}</div>
										<div class="course-commnet-like">
											<span>Helpful?</span>
											<span>
												<i class="bi bi-hand-thumbs-up"> </i>
												<i class="bi bi-hand-thumbs-down"></i>
											</span>
										</div>
									</div>	`;
                });
                $(".course-comment-wrapper").html(htmlResult);
                if (response["status"] == -1) {
                    that.html("That's all");
                } else {
                    that.html("Show more");
                }
            }, 1000);
        },
    });
});

//Share Khoá học
$("#fb-share-button").click(function () {
    var shareUrl =
        "https://www.facebook.com/sharer/sharer.php?u=" +
        encodeURIComponent(window.location.href);

    // Mở cửa sổ popup mới
    window.open(shareUrl, "_blank", "width=600,height=400");
});

$(".count-content-video").click(function (e) {
    let url = $(this).data("url");
    let that = $(this);
    $(".video-blur").fadeIn(300);
    $("#chapter_video_link").attr("src", url);
    $(".video").animate(
        {
            top: "50%",
        },
        300
    );
    if ($(this).html() == "Watch") {
        let urlRequest = $(this).data("request");
        $.ajax({
            type: "get",
            url: urlRequest,
            success: function (response) {
                that.next().removeClass("progress-incomplete");
                that.next().addClass("progress-complete");
            },
        });
    }
});
$(".video-blur").click(function (e) {
    $(".video-blur").fadeOut(300);
    $(".video").animate(
        {
            top: "-1000px",
        },
        300
    );
});

// Show Popup Position
var courseCover = $(".course-cover");
var popupCourse = $(".course-popup-container");
var popupCourseOffsetLeft =
    courseCover.offset().left +
    courseCover.outerWidth() +
    (5 * (courseCover.outerWidth() / 65) * 100) / 100;

var header = $(".navs");
var heightNav = header.outerHeight();
var footer = $("footer");

$(window).on("scroll", function () {
    if ($(window).scrollTop() >= heightNav) {
        if ($(window).innerWidth() < 767) {
            popupCourse.css({ bottom: "0", top: "unset" });
        } else {
            popupCourse.css({ bottom: "unset", top: "50px" });
        }
    } else {
        if ($(window).innerWidth() < 767) {
            popupCourse.css({ bottom: "0", top: "unset" });
        } else {
            popupCourse.css({ bottom: "unset", top: "70px" });
        }
    }
});

if ($(window).innerWidth() > 767) {
    popupCourse.css({ left: popupCourseOffsetLeft + "px" });
    popupCourse.css({
        width: (30 * (courseCover.outerWidth() / 65) * 100) / 100 + "px",
    });

    $(window).on("scroll", function () {
        var popUpoffSetBottom =
            $(window).scrollTop() +
            $(window).innerHeight() -
            footer.offset().top;
        if (popUpoffSetBottom > 0) {
            popupCourse.css({
                top: "unset",
                bottom: popUpoffSetBottom + 20 + "px",
            });
        }
    });
}

if ($(window).innerWidth() < 767) {
    popupCourse.css({ left: 0, width: "100%", bottom: 0, top: "unset" });
}

// Like , dislike or report
$(".course-comment-wrapper").on("click", function (e) {
    if ($(e.target).hasClass("bi-hand-thumbs-up")) {
        $(e.target)
            .removeClass("bi-hand-thumbs-up")
            .addClass("bi-hand-thumbs-up-fill");
        if ($(e.target).next().hasClass("bi-hand-thumbs-down-fill")) {
            $(e.target)
                .next()
                .removeClass("bi-hand-thumbs-down-fill")
                .addClass("bi-hand-thumbs-down");
        }
    } else if ($(e.target).hasClass("bi-hand-thumbs-down")) {
        $(e.target)
            .removeClass("bi-hand-thumbs-down")
            .addClass("bi-hand-thumbs-down-fill");
        if ($(e.target).prev().hasClass("bi-hand-thumbs-up-fill")) {
            $(e.target)
                .prev()
                .removeClass("bi-hand-thumbs-up-fill")
                .addClass("bi-hand-thumbs-up");
        }
    } else if ($(e.target).hasClass("bi-hand-thumbs-down-fill")) {
        $(e.target)
            .removeClass("bi-hand-thumbs-down-fill")
            .addClass("bi-hand-thumbs-down");
    } else if ($(e.target).hasClass("bi-hand-thumbs-up-fill")) {
        $(e.target)
            .removeClass("bi-hand-thumbs-up-fill")
            .addClass("bi-hand-thumbs-up");
    }
    if ($(e.target).hasClass("course-comment-report")) {
        $(e.target).find(".course-comment-report-popup").toggleClass("show");
    }
});
//  Xử lý phần report
$(document).on("click", ".course-comment-report-popup", function () {
    let that = $(this);
    let urlRequest = $(this).data("url");
    $.ajax({
        type: "get",
        url: urlRequest,
        success: function (response) {
            $(".loading").addClass("show");
            setTimeout(() => {
                $(".loading").removeClass("show");
                that.removeClass("show");
            }, 300);
        },
    });
});

// Print this course
$(".course-print").on("click", handlePrintCourse);

function handlePrintCourse() {
    var divContentTop = $(".course-wrapper").html();
    var divContentBody = $(".course-intro").html();
    var divContentBot1 = $(".course-content").html();
    var divContentBot2 = $(".course-content-info-print").html();

    var a = window.open("", "", "height=500, width=500");
    a.document.write("<html>");
    a.document.write(
        `<head>
      <meta charset="UTF-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title>Star Classes - Print Course</title>
      <link rel="icon" type="image/x-icon" href="http://127.0.0.1:8000/x-icon.ico" />
      <link rel="stylesheet" href="http://127.0.0.1:8000/css/style.css" />
      <link rel="stylesheet" href="http://127.0.0.1:8000/css/coursedesc.css" />
      <link rel="stylesheet" href="http://127.0.0.1:8000/css/print.css" />
    </head>`
    );
    a.document.write(
        `<main>
      <div class="course-wrapper">`
    );
    a.document.write(`<div class="print-company">
                    <a href="http://127.0.0.1:8000/" class="logo logo-animation">
                      <div class="logo-inner">
                        <img src="http://127.0.0.1:8000/images/logo.png" alt="" />
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
    a.document.close();
    a.focus();

    setTimeout(function () {
        a.print();
    }, 1000);

    return true;
}

var time = new Date().toLocaleString("vi-VI");

// Click Show Hide Chapter
var deg = 0;

$(".chapter-parent").on(
    "click",
    debounce(function () {
        var nextElement = $(this).next();
        nextElement.slideToggle(300);
        let icon = $(this).find(".bi-chevron-up");
        icon.toggleClass("rotate");
        icon.toggleClass("rotate-reset");
    }, 300)
);
