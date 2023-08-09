import { reloadPage } from "./utilities.js";

// Lưu giữ giá trị scroll
reloadPage();

let itemWidth = $(".course-item").width() + 10;
let i = 0;
let filter = "student";
$(".teacher-pre").hide();
if (mostPopular <= 5) {
    $(".teacher-pre").hide();
    $(".teacher-next").hide();
}

$(".tag-menu-item").click(function (e) {
    e.preventDefault();
    filter = $(this).data("filter");
    $(".tag-menu-item").removeClass("tag-is-active");
    $(this).addClass("tag-is-active");
    if (filter == "student") {
        $("#most-popular").show();
        $("#newest").hide();
    } else {
        $("#most-popular").hide();
        $("#newest").show();
    }
});
$(".teacher-next").click(function (e) {
    $(".teacher-pre").show();
    e.preventDefault();
    i++;
    if (i + 5 >= 6) {
        $(this).hide();
    } else {
        $(this).show();
    }
    if (filter == "student") {
        $("#most-popular").css(
            "transform",
            "translateX(-" + itemWidth * i + "px)"
        );
    } else {
        $("#newest").css("transform", "translateX(-" + itemWidth * i + "px)");
    }
});

$(".teacher-pre").click(function (e) {
    $(".teacher-next").show();
    if (i == 0) {
        $(this).hide();
        return;
    }
    i--;
    if (i <= 0) {
        $(this).hide();
    } else {
        $(this).show();
    }
    if (filter == "student") {
        $("#most-popular").css(
            "transform",
            "translateX(-" + itemWidth * i + "px)"
        );
    } else {
        $("#newest").css("transform", "translateX(-" + itemWidth * i + "px)");
    }
});

//Phần filter

$("#clear-filter").click(function (e) {
    e.preventDefault();
    let url = $(this).data("clear");
    $("[type=radio]").prop("checked", false);
    window.open(url, "_self");
});

$("#filter").change(function (e) {
    e.preventDefault();
    var form = $(this);
    var actionUrl = form.attr("action");
    console.log(actionUrl);
    getHtmlResult(actionUrl);
});

function getHtmlResult(actionUrl) {
    let sort_by = $('[name="sort_by"]:checked').val();
    let star = $('[name="star"]:checked').val();
    let page = $("#page").val();
    let data = {
        slug: department_slug,
        sort_by: sort_by,
        star: star,
        page: page,
    };
    // thay đổi URL hiển thị trong thanh địa chỉ
    history.pushState(null, "", getUrlDisplay());
    $.ajax({
        type: "get",
        url: actionUrl,
        data: data,
        success: function (response) {
            let htmlResult = "";
            response.forEach((course) => {
                htmlResult += `<a class="search-result-item" href="course/${
                    course["slug"]
                }">
												<div class="search-result-img">
													<img src="${course["thumbnail"]} " alt="">
												</div>
												<div class="search-result-wrapper">
													<div class="search-result-info">
														<div class="search-result-name">${course["name"]}</div>
														<div class="search-result-desc">
														${course["description"]}
														</div>
														<div class="course-teacher-name">${course["teacher_name"]}</div>
														<div class="course-students-count">
															<i class="bi bi-people-fill"></i>
															<span>${course["students"]}</span>
														</div>
														<div class="search-result-star">
															<span>${course["star"]}</span>
															<span class="course-star">
																<i class="bi bi-star-fill"></i>
															</span>
															<span>(${course["number_reviews"]})</span>
														</div>
														<div class="search-result-time">
															<span>04 hours total</span><i class="bi bi-dot"></i>
															<span>Update ${course["updated_at"].split("T")[0]}</span>
														</div>
													</div>
													<div class="search-result-price">
														<div>${course["discount"]}$</div>
														<div>${course["price"]}$</div>
													</div>
												</div>
											</a>`;
            });
            $(".search-result-display").html(htmlResult);
        },
    });
}

function getUrlDisplay() {
    let actionUrl = "/department/" + department_slug;
    let sort_by = $('[name="sort_by"]:checked').val();
    let star = $('[name="star"]:checked').val();
    let page = $("#page").val();
    sort_by ? (sort_by = "?sort_by=" + sort_by) : (sort_by = "");
    star ? (star = "&star=" + star) : (star = "");
    page ? (page = "&page=" + page) : (page = "");
    actionUrl += "?sort=true" + sort_by + star + page;
    return actionUrl;
}

// Load tại vị trí mới
$("#view-more").click(function (e) {
    e.preventDefault();
    let nextPage = parseInt($("#page").val()) + 1;
    if (nextPage * 5 > count) {
        $(this).html("That's all");
        return;
    }
    $("#page").val(nextPage);
    var actionUrl = $("#filter").attr("action");
    getHtmlResult(actionUrl);
});

// Show hide filter menu
// Show Hide Menu When Click
var deg = 0;
var searchItems = document.querySelectorAll(".search-item-title");
searchItems.forEach((item) => {
    item.nextElementSibling.classList.add("search-item-hide");
    item.addEventListener("click", function () {
        item.nextElementSibling.classList.toggle("search-item-hide");
        item.nextElementSibling.classList.toggle("search-item-show");
        if (item.lastElementChild.classList.contains("rotate")) {
            item.lastElementChild.style.animation = "none";
            item.lastElementChild.style.animation =
                "rotate-left 0.1s ease-in-out both";
        } else {
            item.lastElementChild.style.animation = "none";
            item.lastElementChild.style.animation =
                "rotate-right 0.1s ease-in-out both";
        }
        if (deg == 0) deg = 180;
        if (deg == 180) deg = 0;
        item.lastElementChild.classList.toggle("rotate");
    });
});
